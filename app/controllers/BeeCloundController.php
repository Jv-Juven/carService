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
			3.如果是退款（暂时未做）
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
		$appId 		= Config::get('beeCloud.app_secret');
		$appSecret 	= Config::get('beeCloud.app_id');
		$jsonStr 	= file_get_contents("php://input");
		$msg 		= json_decode($jsonStr);
		$data 		= Cache::get($msg->transactionFee);//支付数据
		Log::info( $msg );
		Log::info( $data );

		if( !isset( $data ))
			return Response::json(array('errCode'=>21, 'message'=>''));
		//验证签名
		$sign = md5($appId . $appSecret . $msg->timestamp);
		if ( $sign != $msg->sign ) 
		    return Response::json(array( 'errCode'=>22, 'message'=>'验证码不正确' ));

		//订单金额
		if($data['total_fee'] != $msg->transactionFee)
		    return Response::json(array( 'errCode'=>23, 'message'=>'金额不不正确' ));

		//订单号
		if($data['bill_no'] != $msg->transactionId)
		    return Response::json(array( 'errCode'=>24, 'message'=>'订单号' ));

		if($msg->transactionType == "PAY") {
	    
		    $message_detail =$msg->messageDetail;
		    
	        if( $message_detail->total_fee*100 != $data['total_fee'])
	        	return Response::json(array( 'errCode'=>24, 'message'=>'金额不不正确' ));
		    
		    //判断是代办还是充值，有user_id为充值
		    if( isset($msg->optional->user_id) )
		    {
			     $cost_detail = New CostDetail;
			     $cost_detail->user_id 		= $msg->optional->user_id;
			     $cost_detail->cost_id 		= $data['total_fee'];
			     $cost_detail->fee_type_id 	= FeeType::where( 'category', FeeType::get_recharge_code() )
									->where( 'item', FeeType::get_rechage_subitem() )
									->first();
				if( !$cost_detail->save() )	
				 	return 'false';

				 return 'sucess';
		    }else{
		    	$order = AgencyOrder::find( $data['bill_no'] );
		    	$order->trade_status = 1; //已付款
		    	$order->process_status = 1; //未处理
		    	if( !$order->save() ) 
		    		return 'false';

		    	return 'sucess';
		    }

			} else if ($msg->transactionType == "REFUND") {
				//更改退款状态
		}	
	}	
	/*
	$recharge_fee_type = FeeType::where( 'category', FeeType::get_recharge_code() )
							->where( 'item', FeeType::get_rechage_subitem() )
							->first()
	*/

	/* 微信支付－充值
	 * parm：money
	 */
	public function recharge()
	{	
		$data = $this->returnDataArray();
		$data["channel"] = "WX_NATIVE";

		$money = 1;
		// $money = Input::get('money');
		if( !is_int( $money ) )
			return Response::json(array('errCode'=>21, 'message'=>'请输入正确的金额'));
		
		$data["bill_no"] 	= CostDetail::get_unique_id();
		$data["total_fee"] 	= $money; 
		$data['title']		= '充值';
		$data["optional"] 	= json_decode(json_encode(array("user_id"=>Sentry::getUser()->user_id)));
		Cache::put($data["bill_no"],$data,30);
		
	    $result = BCRESTApi::bill($data);
	    if ($result->result_code != 0) {
	        return  json_decode( json_encode($result,true), true);
	    }
	    $code_url = $result->code_url;//生成支付链接
		//根据不同的支付方式返回不同的支付页面
		return View::make('beeclound.pay')->with(array('bill_no'=>$data['bill_no'], 
												'code_url'=>$code_url));
	}

	/* 微信支付－代办
	 * parm：order_id
	 */
	public function orderAgency()
	{
		$data = $this->returnDataArray();
		$data["channel"] = "WX_NATIVE";

		$order_id = Input::get('order_id');
		if( !isset($order_id) )
			return Response::json(array('errCode'=>21, 'message'=>'请输入订单id' ));

		$order = AgencyOrder::find($order_id);
		if( !isset( $order ) )
			return Response::json(array('errCode'=>21, 'message'=>'该订单不存在'));
 
		$data["bill_no"] 	= $order_id;
		$data["total_fee"] 	= ($order->capital_sum+$order->service_charge_sum+$order->express_fee)*100;
		$data['title'] 		= '订单代办';
		Cache::put($order_id,$data,30);

		$result = BCRESTApi::bill($data);
	    if ($result->result_code != 0) {
	        return  json_decode( json_encode($result,true), true);
	    }
	    $code_url = $result->code_url;//生成支付链接
		//根据不同的支付方式返回不同的支付页面
		return View::make('beeclound.pay')->with(array('bill_no'=>$data['bill_no'], 
												'code_url'=>$code_url));
	}

	//退款
	public function refund()
	{
		$data = $this->returnDataArray();
		$order_id = Input::get('order_id');
		$order = AgencyOrder::find($order_id);
		if( !isset( $order ) )
			return Response::json(array('errCode'=>21, 'message'=>'该订单不存在'));
		$data["bill_no"] = $order->bill_no;
		
		//生成退款单号
		$time = date('Ymd',time());
		$data["refund_no"] = $time.$order->order_id;
		$order->refund_no = $data['refund_no'];
		if( !$order->save() )
			return Response::json(array('errCode'=>22, 'message'=>'退款单号保存失败'));
		
		$data["refund_fee"] = ($order->capital_sum+$order->service_charge_sum+$order->express_fee)*100;
		$data["channel"] = "WX";

		try {
		    $result = BCRESTApi::refund($data);
		    if ($result->result_code != 0 || $result->result_msg != "OK") 
		    {
		      	//此处参数需要打入log中
				return Response::json(array('errCode'=>23, 'message'=>json_encode($result->err_detail)));
		        // echo json_encode($result->err_detail);
		        // exit();
		    }
			return Response::json(array('errCode'=>0, 'message'=>'退款成功'));

		} catch (Exception $e) {
			return Response::json(array('errCode'=>24, 'message'=>$e->getMessage()));
		}
	}	

	//退款状态
	public function refundStatus()
	{
		$data = $this->returnDataArray();
		$data["channel"] = "WX";
	    $data["limit"] = 10;
	    try {
        	$result = BCRESTApi::refunds($data);
	        if ($result->result_code != 0 || $result->result_msg != "OK") {
				
				return Response::json(array('errCode'=>21, 'message'=>json_encode($result->err_detail)));
	            // echo json_encode($result->err_detail);
	            // exit();
        }
        $refunds = $result->refunds;
        echo "<tr><td>更新状态</td><td>退款是否成功</td><td>退款创建时间</td><td>退款号</td><td>订单金额(分)</td><td>退款金额(分)</td><td>渠道类型</td><td>订单号</td><td>退款是否完成</td><td>订单标题</td></tr>";
        foreach($refunds as $list) {
            echo "<tr>";
            echo "<td><a href='update-refund-status?refund_no=".$list->refund_no."'>更新</a></td>";
            foreach($list as $k=>$v) {
                echo "<td>".($k=="result"?($v?"成功":"失败"):($k=="created_time"?date('Y-m-d H:i:s',$v/1000):($k=="finish"?($v?"完成":"未完成"):$v)))."</td>";
            }
            echo "</tr>";
        }
	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }
		return View::make('refund-status');
	}

	//更新退款状态
	public function updateRefundStatus()
	{	
		$data = $this->returnDataArray();
		try {
		    $result = BCRESTApi::refundStatus($data);
		    if ($result->result_code != 0 || $result->result_msg != "OK") {
			
			    return Response::json(array('errCode'=>21, 'message'=>json_encode($result->err_detail)));
		    }
		    return Response::json(array('errCode'=>0));

		} catch (Exception $e) {
		   
		    return Response::json(['errCode'=>21, 'message'=>$e->getMessage()]);
		}
	}

}