<?php

/*
支付逻辑：
		客户端调用beeClound()方法，在 付款成功／退款成功后 
		调起authClound()方法验证第三方（beeCloud）
		传回来的订详情是否正确，如果正确即
			1.如果是充值
				调起充值接口BusinessController中的recharge()
				对对应的账户进行充值	
			2.如果是代办	
				更改订单状态
			3.如果是退款
				更改订单状态
		
		authCloud()接口验证的字段：
		1. 签名
		2. 订单号
		3. 交易金额
		4. 支付宝返回的total_fee（商品总价），subject（订单标题）
		5. 微信返回的total_fee（商品总价
*/
class BeeCloundController extends BaseController{

	public function returnDataArray()
	{
		$data = array();
		$appSecret = Config::get('beeCloud.app_secret');
		$data["app_id"] = Config::get('beeCloud.app_id');
		$data["timestamp"] = time() * 1000;
		$data["app_sign"] = md5($data["app_id"] . $data["timestamp"] . $appSecret);
		return $data;
	}

	//验证支付返回信息是否正确－正确时调用充值接口
	public function authBeeCloud()
	{		
		// return 'success';
		$appId 		= Config::get('beeCloud.app_id');
		$appSecret 	= Config::get('beeCloud.app_secret');
		$jsonStr 	= file_get_contents("php://input");
		$msg 		= json_decode($jsonStr,true);
		// Log::info( $msg );
		$data 		= Cache::get( $msg['transactionId'] );//支付数据
		// Log::info( $data );

		if( !isset( $data ))
		{
			Log::info( 'data有错' );
			return 'false';
		}
		//验证签名
		$sign = md5($appId . $appSecret . $msg['timestamp'] );
		if ( $sign != $msg['sign'] ) 
		{
			Log::info( '签名有错' );
		    return Response::json(array( 'errCode'=>21, 'message'=>'验证码不正确' ));
		}  

		//订单号
		if($data['bill_no'] != $msg['transactionId'])
		{
			Log::info( '订单号有错' );
		    return Response::json(array( 'errCode'=>22, 'message'=>'订单号' ));
		}    

		if($msg['transactionType'] == "PAY") 
		{
	    
		    $message_detail =$msg['messageDetail'];
		    
		    //订单金额
			if($data['total_fee'] != $msg['transactionFee'])
			{
				Log::info( '金额有错有错' );
			    return Response::json(array( 'errCode'=>23, 'message'=>'金额不不正确' ));
			}

	        if( $message_detail['total_fee'] != $data['total_fee'])
	        {
	        	Log::info( 'messageDetail中金额有错' );
	        	return Response::json(array( 'errCode'=>24, 'message'=>'金额不不正确' ));
	        }
		    
		    //判断是代办还是充值，有user_id为充值
		    if( isset($msg['optional']['user_id']) )
		    {	
			    try
			    {
			    	DB::transaction(function() use( $data,$msg ) {

					    $cost_detail = New CostDetail;
					    $cost_detail->user_id 		= $msg['optional']['user_id'];
					    $cost_detail->cost_id 		= $data["bill_no"];
					    $cost_detail->fee_type_id 	= FeeType::where( 'category', FeeType::get_recharge_code() )
																->where( 'item', FeeType::get_recharge_subitem() )
																->first()->id;
					    $cost_detail->number 		= $data['total_fee'];
						$cost_detail->save();
						
						$result =  BusinessController::recharge($data['total_fee'],$msg['optional']['user_id']);
						if( !$result )
							throw new Exception;
			    	});
			    }catch( \Exception $e )
			    {	
			    	Log::info( 'try错误' );
			    	return 'false';
			    }
			    return 'success';
		    }else{
		    	$order = AgencyOrder::find( $data['bill_no'] );
		    	$order->trade_status = 1; //已付款
		    	$order->process_status = 1; //未处理
		    	if( !$order->save() ) 
		    		return 'false';

		    	return 'success';
		    }

		}

		//退款逻辑
		if ($msg['transactionType'] == "REFUND") 
		{
			//退款
			if($data['refund_fee'] != $msg['transactionFee'])
			{
				Log::info( '退款金额有错' );
			    return Response::json(array( 'errCode'=>25, 'message'=>'退款金额有错' ));
			}

			//更改状态
			$refund_id = $msg['optional']['refund_id']
			$refund = RefundRecord::find($refund);
			$order 	= AgencyOrder::find($data['refund_no']);
			try
			{
				DB::transaction( function() use( $refund,$order ) {
					$refund->status = 2;
					$refund->save();

					$order->trade_status = 3;
					$order->process_status = 3;
					$order->save();
				});
			}catch( Exception $e )
			{
				return 'false';
			}

			return 'success';
		}	
	}	



	/* 微信支付－充值
	 * parm：money
	 */
	public function recharge()
	{	
		$data = $this->returnDataArray();
		$data["channel"] = "WX_NATIVE";

		// $money = 1;
		$money = Input::get('money');
		if( !is_int( $money ) )
			return Response::json(array('errCode'=>21, 'message'=>'请输入正确的金额'));
		
		$data["bill_no"] 	= CostDetail::get_unique_id();
		$data["total_fee"] 	= $money*100; 
		$data['title']		= '充值';
		$data["optional"] 	= json_decode(json_encode(array("user_id"=>Sentry::getUser()->user_id),true),true);
		Cache::put($data["bill_no"],$data,120);
	    
		try
		{
			$result = BCRESTApi::bill($data);
		    if ($result->result_code != 0) {
		        return  Response::json(array('errCode'=>22,'message'=>$result)) ;
		    }
		    $code_url = $result->code_url;//生成支付链接
		}catch (Exception $e) {
		    return  Response::json(array('errCode'=>23,'message'=>$e->getMessage())) ;
		}
		$qrcode = array();
		$qrcode['bill_no'] = $data['bill_no'];
		$qrcode['code_url'] = $code_url;
		Session::put('qrcode',$qrcode);

		return Response::json(array('errCode'=>0,'message'=>'ok'
												'url'=>'/beeclound/qrcode'
									));
	}

	/* 微信支付－代办
	 * parm：order_id
	 */
	public function orderAgency()
	{
		$data = $this->returnDataArray();
		$data["channel"] = "WX_NATIVE";
		// $order_id = 'dbdd5617c95a48d75575926400';
		$order_id = Input::get('order_id');
		if( !isset($order_id) )
			return Response::json(array('errCode'=>21, 'message'=>'请输入订单id' ));

		$order = AgencyOrder::find($order_id);
		if( !isset( $order ) )
			return Response::json(array('errCode'=>22, 'message'=>'该订单不存在'));
 
		$data["bill_no"] 	= $order_id;
		$data["total_fee"] 	= (int)(($order->capital_sum+$order->service_charge_sum+$order->express_fee)*100);
		$data['title'] 		= '订单代办';
		Cache::put($order_id,$data,1440);
		// dd( $data["total_fee"] );
		try
		{
			$result = BCRESTApi::bill($data);
		    if ($result->result_code != 0) {
		        return  Response::json(array('errCode'=>23,'message'=>$result)) ;
		    }
		    $code_url = $result->code_url;//生成支付链接
		}catch (Exception $e) {
		    return  Response::json(array('errCode'=>24,'message'=>$e->getMessage())) ;
		}

		$qrcode = array();
		$qrcode['bill_no'] = $data['bill_no'];
		$qrcode['code_url'] = $code_url;
		Session::put('qrcode',$qrcode);

		return Response::json(array('errCode'=>0,'message'=>'ok',
											'url'=>'/beeclound/qrcode'
								));
	}

	//支付页面
	public function qrcode( )
	{	
		$qrcode = Session::get('qrcode');
		return View::make('beeclound.pay')->with(array(
											'bill_no'=> $qrcode['bill_no'], 
											'code_url'=>$qrcode['code_url']
											);
	}		


	//退款
	public function refund()
	{
		$data = $this->returnDataArray();
		// $order_id = 'dbdd5617c95a48d75575926400';
		// $order_id = Input::get('order_id');
		// $order = AgencyOrder::find($order_id);
		// if( !isset( $order ) )
		// 	return Response::json(array('errCode'=>21, 'message'=>'该订单不存在'));
		
		$refund_id = Input::get('refund_id');
		$refund = RefundRecord::find( $refund_id );
		if( !isset( $refund) )
			return Response::json(array('errCode'=>21, 'message'=>'该订单不存在'));

		$order = AgencyOrder::find( $refund->order_id );
		$data["bill_no"] = $order->order_id;
		
		$data["refund_no"] = date('Ymd',time()).time();
		
		$data["refund_fee"] = (int)(($order->capital_sum+$order->service_charge_sum+$order->express_fee)*100);
		$data["channel"] = "WX";
		$data["optional"] 	= json_decode(json_encode(array("refund_id"=>$refund_id),true),true);


		Cache::put($data["bill_no"],$data,120);
		try {
		    $result = BCRESTApi::refund($data);
		    if ($result->result_code != 0 || $result->result_msg != "OK") 
		    {
				return Response::json(array('errCode'=>22, 'message'=>$result->err_detail));
		    }
		} catch (Exception $e) {
			return Response::json(array('errCode'=>23, 'message'=>$e->getMessage()));
		}

		try{
			DB::transaction( function() use( $order,$refund ) {

				$order->process_status = 2;
				$order->save();

				$refund->refund_no = $data["refund_no"];
				$refund->status = 1; 
				$refund->save();
			});
		}catch( Exception $e)
		{
			return Response::json(array('errCode'=>24, 'message'=>'退款状态修改失败' ));
		}

		return Response::json(array('errCode'=>0, 'message'=>'退款已提交'));
	}	

	//更新退款状态
	public function updateRefundStatus()
	{	
		$data = $this->returnDataArray();
		$refund_id =  Input::get('refund_id');
		$refund = RefundRecord::find( $refund_id );
		if( !isset($refund) )
			return Response::json(array('errCode'=>21, 'message'=>'该订单不存在'));

		$data["refund_no"] = $refund->refund_no;

		try {		
		    $result = BCRESTApi::refundStatus($data);
		    if ($result->result_code != 0 || $result->result_msg != "OK") {
			
			    return Response::json(array('errCode'=>21, 'message'=>json_encode($result->err_detail)));
		    }
		    return Response::json(array('errCode'=>0,'refund_status'=>$result->refund_status));

		} catch (Exception $e) {
		   
		    return Response::json(['errCode'=>22, 'message'=>$e->getMessage()]);
		}
	}

	//退款状态--不需要
	public function refundStatus()
	{
		$data = $this->returnDataArray();
		$data["channel"] = "WX";

		if( $data["channel"] != 'WX' || $data["channel"] != 'ALI' )
			return  Response::json(array('errCode'=>21,'message'=>'WX或ALI两种方式'));

	    try {
        	$result = BCRESTApi::refunds($data);
	        if ($result->result_code != 0 || $result->result_msg != "OK") {
				
				return Response::json(array('errCode'=>22, 'message'=>json_encode($result->err_detail)));
	    	}
	    } catch (Exception $e) {
	        return Response::json(array('errCode'=>23, 'message'=>$e->getMessage()));
	    }

        $refunds = $result->refunds;
       
        return Response::json(array('errCode'=>0, 'refunds'=> $refunds));
	}
}