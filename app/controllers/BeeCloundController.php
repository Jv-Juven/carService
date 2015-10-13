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
class BeeCloudController extends BaseController{

	public static function returnDataArray()
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
		
		Log::info( $msg );
		Log::info( $msg['transactionId'] );
		$info = OrderAuthInfo::where('transactionId', $msg['transactionId'] )->first();
		if( !isset( $info ))
		{
			Log::info('无此数据');
			return 'false';
		}
		Log::info( $info );
		
		//验证签名
		$sign = md5($appId . $appSecret . $msg['timestamp'] );
		if ( $sign != $msg['sign'] ) 
		{
			Log::info( '签名有错' );
		    return Response::json(array( 'errCode'=>21, 'message'=>'验证码不正确' ));
		}  

		//订单号
		if( $info->transactionId != $msg['transactionId'])
		{
			Log::info( '订单号有错' );
		    return Response::json(array( 'errCode'=>22, 'message'=>'订单号' ));
		}    

		if($msg['transactionType'] == "PAY") 
		{
	    
		    $message_detail =$msg['messageDetail'];
		    
		    //订单金额
			if( $info->transactionFee != $msg['transactionFee'])
			{
				Log::info( '金额有错有错' );
			    return Response::json(array( 'errCode'=>23, 'message'=>'金额不不正确' ));
			}

	        if( $message_detail['total_fee'] != $info->transactionFee )
	        {
	        	Log::info( 'messageDetail中金额有错' );
	        	return Response::json(array( 'errCode'=>24, 'message'=>'金额不不正确' ));
	        }
		    
		    //判断是代办还是充值，有user_id为充值
		    if( isset($msg['optional']['user_id']) )
		    {	
			    try
			    {
			    	DB::transaction(function() use( $info,$msg ) {

					    $cost_detail = New CostDetail;
					    $cost_detail->user_id 		= $msg['optional']['user_id'];
					    $cost_detail->cost_id 		= $info->transactionId;
					    $cost_detail->fee_type_id 	= FeeType::where( 'category', FeeType::get_recharge_code() )
																->where( 'item', FeeType::get_recharge_subitem() )
																->first()->id;
					    $cost_detail->number 		= $info->transactionFee;
						$cost_detail->save();
						Log::info( $info->transactionFee );
						Log::info( $msg['optional']['user_id'] );
						$result =  BusinessController::recharge($info->transactionFee*100,$msg['optional']['user_id']);
						if( !$result )
							throw new Exception;
			    	});
			    }catch( \Exception $e )
			    {	
			    	Log::info( $e->getMessage() );
			    	return 'false';
			    }

			    $info->delete();
			    return 'success';
		    }else{
		    	$order = AgencyOrder::find( $info->transactionId );
		    	if( $data['channel'] == 'WX_NATIVE' )
		    	{	
		    		$order->pay_trade_no = $message_detail['transaction_id'];//交易流水号	
		    		$order->pay_platform = 0;//支付平台
		    	}else{
		    		$order->pay_trade_no = $message_detail['trade_no'];
		    		$order->pay_platform = 1;
		    	}

		    	$order->trade_status = 1; //已付款
		    	$order->process_status = 1; //已受理
		    	if( !$order->save() ) 
		    		return 'false';

		    	$info->delete();
		    	return 'success';
		    }

		}

		//退款逻辑
		if ($msg['transactionType'] == "REFUND") 
		{
			//退款
			if( $info->transactionFee != $msg['transactionFee'])
			{
				Log::info( '退款金额有错' );
			    return Response::json(array( 'errCode'=>25, 'message'=>'退款金额有错' ));
			}

			//更改状态
			$refund_id = $msg['optional']['refund_id'];
			$refund = RefundRecord::find($refund);
			$order 	= AgencyOrder::find( $info->transactionId );
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
				Log::info( $e->getMessage() );
				return 'false';
			}
			$info->delete();
			return 'success';
		}	
	}	



	/* 微信支付－充值
	 * parm：money
	 */
	public function recharge()
	{	
		$data = static::returnDataArray();
		
		// $channel = Input::get('channel');
		// if( $channel != 'WX_NATIVE' || $channel != 'ALI_QRCODE' );
		// 	return Response::json(array( 'errCode'=>21, 'message'=>'支付方式只能选去微信或支付宝') );
		// $data["channel"] = $channel;
		
		$data["channel"] = "WX_NATIVE";
		$money = 1;
		// $money = Input::get('money');
		
		$data["bill_no"] 	= CostDetail::get_unique_id();
		$data["total_fee"] 	= $money;//单位换算成分 $money*100
		$data['title']		= '充值';
		$data["optional"] 	= json_decode(json_encode(array("user_id"=>Sentry::getUser()->user_id),true),true);
		
		$order_auth_info = new OrderAuthInfo;
		$order_auth_info->transactionId =  $data["bill_no"];//交易单号
		$order_auth_info->transactionFee = $data["total_fee"];//费用
		if( !$order_auth_info->save() )
			return Response::json(array('errCode'=>22, 'message'=>'数据库保存错误' ));

		Cache::put($data["bill_no"],$data,120);
	    
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

	/* 微信支付－代办
	 * parm：order_id
	 */
	public function orderAgency()
	{
		$data = static::returnDataArray();
		
		// $channel = Input::get('channel');
		// if( $channel != 'WX_NATIVE' || $channel != 'ALI_QRCODE' );
		// 	return Response::json(array( 'errCode'=>21, 'message'=>'支付方式只能选去微信或支付宝') );
		// $data["channel"] = $channel;

		$data["channel"] = "WX_NATIVE";
		// $order_id = 'dbdd5617c95a4840d721873877';
		$order_id = Input::get('order_id');
		if( !isset($order_id) )
			return Response::json(array('errCode'=>21, 'message'=>'请输入订单id' ));

		$order = AgencyOrder::find($order_id);
		if( !isset( $order ) )
			return Response::json(array('errCode'=>22, 'message'=>'该订单不存在'));
 
		$data["bill_no"] 	= $order_id;
		$data["total_fee"] 	= (int)(($order->capital_sum+$order->service_charge_sum+$order->express_fee)*100);
		$data['title'] 		= '订单代办';
		
		$order_auth_info = new OrderAuthInfo;
		$order_auth_info->transactionId =  $data["bill_no"];//交易单号
		$order_auth_info->transactionFee = $data["total_fee"];//费用
		if( !$order_auth_info->save() )
			return Response::json(array('errCode'=>23, 'message'=>'数据库保存错误' ));

		Cache::put($order_id,$data,1440);
		// dd( $data["total_fee"] );
		try
		{
			$result = BCRESTApi::bill($data);
		    if ($result->result_code != 0) {
		        return  Response::json(array('errCode'=>24,'message'=>$result)) ;
		    }
		    $code_url = $result->code_url;//生成支付链接
		}catch (Exception $e) {
		    return  Response::json(array('errCode'=>25,'message'=>$e->getMessage())) ;
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
											));
	}		


	//退款
	public static function refund( $refund_id, $channel = 'WX' )
	{
		$data = static::returnDataArray();
		
		$refund = RefundRecord::find( $refund_id );
		if( !isset( $refund) )
			return (array('errCode'=>21, 'message'=>'该订单不存在'));

		$order = AgencyOrder::find( $refund->order_id );
		$data["bill_no"] = $order->order_id;
		
		$data["refund_no"] = date('Ymd',time()).time();
		
		$data["refund_fee"] = (int)(($order->capital_sum+$order->service_charge_sum+$order->express_fee)*100);
		
		$data["channel"] = $channel;
		$data["optional"] 	= json_decode(json_encode(array("refund_id"=>$refund_id),true),true);

		$order_auth_info = new OrderAuthInfo;
		$order_auth_info->transactionId =  $data["refund_no"];//交易单号
		$order_auth_info->transactionFee = $data["refund_fee"];//费用
		if( !$order_auth_info->save() )
			return array('errCode'=>22, 'message'=>'数据库保存错误' );

		try{
				$result = BCRESTApi::refund($data);	
				if ($result->result_code != 0 || $result->result_msg != "OK") 
					return array('errCode'=>24, 'message'=>json_encode($result->err_detail));
		}catch( Exception $e)
		{
			return array('errCode'=>24, 'message'=>$e->getMessage() );
		}

		return array('errCode'=>0, 'message'=>'退款已提交');
	}	

	//退款状态
	public function refundStatus( $refund_no ,$channel = 'WX' )
	{
		$data = static::returnDataArray();
		
		$data["channel"] = $channel;
		$data["refund_no"] = $refund_no;
	    try {
        	$result = BCRESTApi::refunds($data);
	        if ($result->result_code != 0 || $result->result_msg != "OK") {
				
				return array('errCode'=>24, 'message'=>json_encode($result->err_detail));
	    	}
	    } catch (Exception $e) {
	        return array('errCode'=>25, 'message'=>$e->getMessage());
	    }
       	
       	return array(	'errCode'=>0, 
						'message'=>'ok', 
						'result'=>$result->refunds[0]->result,
						'finish'=>$result->refunds[0]->finish
							);
        
	}

	//更新退款状态并获取
	public static function getRefundStatus( $refund_id,$channel = 'WX' )
	{	
		$data = static::returnDataArray();
		
		// if( $channel != 'WX' || $channel != 'ALI' );
		// 	return Response::json(array( 'errCode'=>21, 'message'=>'支付方式只能选去微信或支付宝') );

		$data["channel"] = $channel;
		$refund = RefundRecord::find( $refund_id );
		if( !isset($refund) )
			return array('errCode'=>21, 'message'=>'该订单不存在');

		$data["refund_no"] = $refund->refund_no;

		try {		
		    $result = BCRESTApi::refundStatus($data);
		    if ($result->result_code != 0 || $result->result_msg != "OK") {
			
			    return array('errCode'=>22, 'message'=>$result->err_detail);
		    }

		} catch (Exception $e) {
		   
		    return ['errCode'=>23, 'message'=>$e->getMessage()];
		}

		$results = $this->refundStatus($data["refund_no"], $channel);

		return $results;

	}

	
}