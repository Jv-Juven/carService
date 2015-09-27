<?php

class BusinessController extends BaseController{

	//充值
	public static function recharge()
	{
		$money = Input::get('money');
		if( !isset($money) )
			return Response::json(array('errCode'=>21, 'message'=>'请填写充值金额'));

		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account/recharge';
		$parm = 'appkey='.$appkey.'&money='.$money;
		$recharge =  json_decode( CurlController::post($url,$parm), true);

		if($recharge == null)
			return Response::json(array('errCode'=>22, 'message'=>'系统出现故障，请及时向客服反应'));

		if( $recharge['errCode'] != 0)
		{
			Log::info( $recharge );
			return parent::errMessage($recharge['errCode']);
		}

		return Response::json(array('errCode'=>0, 'message'=>'充值成功','balance'=>$recharge['balance']));
	}

	//获取访问次数信息
	public static function count()
	{
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account/count?appkey='.$appkey;
		$count =  json_decode( CurlController::get($url), true);
		
		if($count == null)
			return Response::json(array('errCode'=>21, 'message'=>'系统出现故障，请及时向客服反应'));

		if( $count['errCode'] != 0)
		{
			Log::info( $count );
			return parent::errMessage($count['errCode']);
		}
		// dd($count['data']);
		return Response::json(array('errCode'=>0, 'message'=>'获取访问次数信息成功','count'=>$count['data']));
	}

	//获取账户信息
	public static function accountInfo()
	{
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account?appkey='.$appkey;

		$account_info = json_decode( CurlController::get($url),true );

		if($account_info == null)
			return Response::json(array('errCode'=>21, 'message'=>'系统出现故障，请及时向客服反应'));

		if( $account_info['errCode'] != 0)
		{
			Log::info( $account_info );
			return parent::errMessage($account_info['errCode']);
		}

		return Response::json(array('errCode'=>0,'message'=>'返回账户信息','account'=>$account_info['account']));

	}

	//修改业务单价<<<<<<管理员接口>>>>>>>
	public static function univalence()
	{	
		$violation 		= Input::get('violation');
		$license 		= Input::get('license');
		$car 			= Input::get('car');
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		// dd($appkey);
		$url = Config::get('domain.server').'/account/univalence';
		$parm = 'appkey='.$appkey.'&violation='.urlencode( $violation ).'&license='.urlencode( $license ).'&car='.urlencode( $car );
		//修改业务单价
		$account_info = json_decode( CurlController::post($url,$parm),true );

		if($account_info == null)
			return Response::json(array('errCode'=>21, 'message'=>'系统出现故障，请及时向客服反应'));

		if( $account_info['errCode'] != 0)
		{
			Log::info( $account_info );
			return parent::errMessage($account_info['errCode']);
		}

		return Response::json(array('errCode'=>0,'message'=>'修改业务单价', 'account_info'=>$account_info['account'])) ;
	}

	//违章查询
	public static function violation()
	{
		$data = array(
				//车牌号码
				'req_car_plate_no' 	=> Input::get('req_car_plate_no'),
				//发动机号码后6位
				'req_car_engine_no' => Input::get('req_car_engine_no'),
				//车辆类型
				'car_type_no' 		=> Input::get('car_type_no')
			);
		$rules = array(
				'req_car_plate_no' 	=> 'required|size:7',
				'req_car_engine_no' => 'required|size:6',
				'car_type_no' 		=> 'required|size:2'
			);

		$messages = array(
				'req_car_plate_no.required'  => 21,
				'req_car_engine_no.required' => 21,
				'car_type_no.required'  	 => 21,
				'req_car_plate_no.size'		 => 22, 
				'req_car_engine_no.size'	 => 23,
				'car_type_no.size'		 	 => 24
			);

		$validation = Validator::make($data, $rules,$messages);
		if($validation->fails())
		{
			$number = $validation->messages()->all();
			switch ($number[0]) {
				case 21:
					return Response::json(array('errCode'=>21, 'message'=>'请将信息填写完整'));
					break;
				case 22:
					return Response::json(array('errCode'=>22, 'message'=>'车牌号码位数不正确'));
					break;
				case 23:
					return Response::json(array('errCode'=>23, 'message'=>'发动机号码位数不正确'));
					break;
				default:
					return Response::json(array('errCode'=>24, 'message'=>'车架号码位数不正确'));
					break;
			}
		}
		
		$token = parent::token();
		$url = Config::get('domain.server').'/api/violation?token='.$token.
				'&licensePlate='.$data['req_car_plate_no'].'&engineCode='.
				$data['req_car_engine_no'].'&licenseType='.$data['car_type_no'];
		$violation = json_decode( CurlController::get($url), true );
		// $violation =  CurlController::get($url);
			
		if($violation == null)
			return Response::json(array('errCode'=>25, 'message'=>'系统出现故障，请及时向客服反应'));

		if( $violation['errCode'] != 0)
		{
			Log::info( $violation );
			return parent::errMessage($violation['errCode']);
		}

		$violation = json_decode( $violation['data'],true);
		if(isset($violation['body'][0]['tips']))
			return Response::json(array('errCode'=>26, 'message'=>'车牌号码或号牌种类错误'));

		//把违章信息存入session中，以便提交订单时生成
		Session::put('violation',$violation['body']);
		return Response::json(array('errCode'=>0, 'message'=>'获取车辆违章信息','violations'=>$violation['body']));
	}

	//查询驾驶证扣分信息
	public static function license()
	{
		$identityID = Input::get('identityID');
		$recordID   = Input::get('recordID');
		$data = array(
				//车牌号码
				'identityID' 	=> Input::get('identityID'),
				//发动机号码后6位
				'recordID' 		=> Input::get('recordID'),
			);
		$rules = array(
				'identityID' 	=> 'required',
				'recordID' 		=> 'required',
			);
		$validation = Validator::make($data, $rules);

		if($validation->fails())
			return Response::json(array('errCode'=>21, 'message'=>'请填写完整的信息'));

		 $token = parent::token();
		 $url = Config::get('domain.server').'/api/license?token='.$token.'&identityID='.
		 					$data['identityID'].'&recordID='.$data['recordID'];
		 $license = json_decode( CurlController::get($url),true );
		
		if($license == null)
			return Response::json(array('errCode'=>22, 'message'=>'系统出现故障，请及时向客服反应'));

		 if( $license['errCode'] != 0 )
		 {
		 	Log::info( $license );
			return parent::errMessage($license['errCode']);
		 }
		 $license = json_decode( $license['data'],true);
		 
		 if($license['returnCode'] == 0)
		 {
		 	return Response::json(array('errCode'=>23,'message'=>'身份证号码，驾驶证号码或档案号码错误'));
		 }
		 $license = json_decode( $license['body'],true);

		 return Response::json(array('errCode'=>0, 'message'=>'驾驶证扣分分数','number'=>$license['ljjf']));
	}	


	//查询车辆信息
	public static function car()
	{
		$data = array(
			'engineCode'		=> Input::get('engineCode'),//发动机号后六位
			'licensePlate' 		=> Input::get('licensePlate'),//车牌号码
			'licenseType' 		=> Input::get('licenseType')//车辆类型
		);

		$rules = array(
			'engineCode' 		=> 'required|size:6',
			'licensePlate' 		=> 'required|size:7',
			'licenseType' 		=> 'required|size:2',
		);

		$messages = array(
				'engineCode.required'  	=> 1,
				'licensePlate.required' => 1,
				'licenseType.required'  => 1,
				'engineCode.size'		=> 2, 
				'licensePlate.size'		=> 3,
				'licenseType.size'	 	=> 4
		);

		$validation = Validator::make($data,$rules,$messages);

		if($validation->fails())
		{
			$number = $validation->messages()->all();
			switch ($number[0]) {
				case 1:
					return Response::json(array('errCode'=>21,'message'=>'信息填写不完整'));
					break;
				case 2:
					return Response::json(array('errCode'=>22,'message'=>'发动机后6位格式不正确'));
					break;
				case 3:
					return Response::json(array('errCode'=>23,'message'=>'车牌号码格式不正确'));
					break;
				default:
					return Response::json(array('errCode'=>24,'message'=>'车辆类型格式不正确'));
					break;
			}
		}
		
		$token = parent::token();
		$url = Config::get('domain.server').'/api/car?token='.$token.'&engineCode='.
		 					$data['engineCode'].'&licensePlate='.$data['licensePlate'].
		 					'&licenseType='.$data['licenseType'];
		$car = json_decode( CurlController::get($url),true );
		
		if($car == null)
			return Response::json(array('errCode'=>25, 'message'=>'系统出现故障，请及时向客服反应'));

		if( $car['errCode'] != 0 )
		{
			Log::info( $car );
			return parent::errMessage($car['errCode']);
		}
		$car = json_decode( $car['data'],true);
		// $car = $car['body'];
		if( $car['returnCode'] == 0)
			return Response::json(array('errCode'=>26, 'message'=>'没有车辆信息，请查看信息是否填写正确'));
	
		return Response::json(array('errCode'=>0, 'message'=>'车辆信息','car'=>$car['body']));
	}

	//提交订单
	public static function trafficViolationInfo()
	{
		$data = array(
			'car_plate_no' 			=> Input::get('car_plate_no'),//车牌号码
			'agency_no'				=> Input::get('agency_no'),//办理笔数
			'capital_sum' 			=> Input::get('capital_sum'),//本金总额
			// 'late_fee_sum' 		=> Input::get('late_fee_sum'),//滞纳金总额
			'service_charge_sum' 	=> Input::get('service_charge_sum'),//代办服务费
		);
		$rules = array(
			'car_plate_no' 			=> 'required',
			'agency_no' 			=> 'required',
			'capital_sum' 			=> 'required',
			'service_charge_sum' 	=> 'required'
		);

		$validation = Validator::make($data,$rules);
		if($validation->fails())
			return Response::json(array('errCode'=>21,'message'=>'信息填写不完整'));

		$is_delivered = Input::get('is_delivered');//是否需要快递
		$data_two = array(
			'express_fee' 		=> Input::get('express_fee'),//快递费
			'recipient_name' 	=> Input::get('recipient_name'),//收件人姓名
			'recipient_addr' 	=> Input::get('recipient_addr'),//收件人地址
			'recipient_phone' 	=> Input::get('recipient_phone'),//收件人手机
			'car_engine_no'		=> Input::get('car_engine_no')//发动机后4位
		);
		$rules_two = array(
			'express_fee'		=> 'required',
			'recipient_name'	=> 'required',
			'recipient_addr'	=> 'required',
			'recipient_phone'	=> 'required',
			'car_engine_no'		=> 'required'
		);
		if(isset($data_two['is_delivered']) == true)
		{
			$validation_two = Validator::make($data_two,$rules_two);
			if($validation_two->fails())
				return Response::json(array('errCode'=>22, 'message'=>'收件人信息填写不完整'));
		}

		$phone_regex = Config::get('regex.telephone');
		if(!preg_match($phone_regex, $data_two['recipient_phone']))
			return Response::json(array('errCode'=>23,'message'=>'收件人信息填写不完整'));

		if(!strlen($data_two['car_engine_no']))
			return Response::json(array('errCode'=>24,'message'=>'发动机后4位格式不正确，请填写4位'));

		try
		{
			DB::transaction(function() use($data,$data_two) {

				$order = new AgencyOrder;
				$order->order_id 			= str_replace('.', '', uniqid( 'dbdd', true ));
				$order->user_id 			= Sentry::getUser()->user_id;
				$order->car_plate_no 		= $data['car_plate_no'];
				$order->agency_no 			= $data['agency_no'];
				$order->capital_sum 		= $data['capital_sum'];
				$order->service_charge_sum 	= $data['service_charge_sum'];
				$order->express_fee 		= $data_two['express_fee'];
				$order->recipient_name 		= $data_two['recipient_name'];
				$order->recipient_addr 		= $data_two['recipient_addr'];
				$order->recipient_phone 	= $data_two['recipient_phone'];
				$order->car_engine_no 		= $data_two['car_engine_no'];
				//在save后不能再取其值
				$order_id = $order->order_id;
				$order->save();
				
				//违章信息存储
				$violations = Session::get('violation');
				foreach( $violations as $violation )
				{
					$violation_info = new TrafficViolationInfo;
					$violation_info->traffic_id 			= str_replace('.', '', uniqid( 'wzxx', true ));
					$violation_info->order_id 				= $order_id;
					$violation_info->req_car_plate_no 		= $violation['hphm'];
					$violation_info->req_car_engine_no 		= $violation['fdjh'];
					$violation_info->car_type_no 			= $violation['hpzl'];
					$violation_info->rep_event_time 		= $violation['wfsj'];
					$violation_info->rep_event_addr 		= $violation['wfdz'];
					$violation_info->rep_violation_behavior = $violation['wfxwzt'];
					$violation_info->rep_point_no 			= $violation['wfjfs'];
					$violation_info->rep_priciple_balance 	= $violation['fkje'];
					//服务费获取
					$user = Sentry::getUser();
					try
					{
						$user_type = UserFee::where('user_id',$user->user_id)->where('item_id',4)->get();
					}catch(\Exception $e)
					{
						$user_type = null;
					}
					$fee_type = FeeType::where('user_type',$user->user_type)
										->where('item_id',4)
										->first();
					// dd($fee_type->number);
					if(isset( $user_type ) )
					{
						$violation_info->rep_service_charge = $user_type->fee_no;
					}else{
						$violation_info->rep_service_charge = $fee_type->number;
					}
					$violation_info->save();
				}
			});
		}catch(\Exception $e)
		{
			return Response::json(array('errCode'=>25,'message'=>'操作失败'.$e->getMessage() ));
		}
		$data['express_fee'] 		= $data_two ['express_fee'];
		$data['recipient_name'] 	= $data_two ['recipient_name'];
		$data['recipient_addr'] 	= $data_two ['recipient_addr'];
		$data['recipient_phone'] 	= $data_two ['recipient_phone'];

		return Response::json(array('errCode'=>0,'message'=>'返回订单信息','order'=>$data));
	}
}