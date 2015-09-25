<?php

class BusinessController extends BaseController{

	//充值
	public function recharge()
	{
		$money = Input::get('money');
		if( !isset($money) )
			return Response::json(array('errCode'=>11, 'message'=>'请填写充值金额'));

		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account/recharge';
		$parm = 'appkey='.$appkey.'&money='.$money;
		$recharge =  json_decode( CurlController::post($url,$parm), true);
		
		if( $recharge['errCode'] != 0)
		{
			Log::info( $recharge );
			return $this->errMessage($recharge['errCode']);
		}

		return Response::json(array('errCode'=>0, 'message'=>'充值成功','balance'=>$recharge['balance']));
	}

	//获取访问次数信息
	public function count()
	{
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account/count?appkey='.$appkey;
		$count =  json_decode( CurlController::get($url), true);
		
		if( $count['errCode'] != 0)
		{
			Log::info( $count );
			return $this->errMessage($count['errCode']);
		}
		dd($count['data']);
		return Response::json(array('errCode'=>0, 'message'=>'获取访问次数信息成功','count'=>$count['data']));
	}

	//获取账户信息
	public function accountInfo()
	{
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account?appkey='.$appkey;

		$account_info = json_decode( CurlController::get($url),true );

		if( $account_info['errCode'] != 0)
		{
			Log::info( $account_info );
			return $this->errMessage($account_info['errCode']);
		}

		return Response::json(array('errCode'=>0,'message'=>'返回账户信息','account'=>$account_info['account']));

	}

	//修改业务单价
	public function univalence()
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

		if( $account_info['errCode'] != 0)
		{
			Log::info( $account_info );
			return $this->errMessage($account_info['errCode']);
		}

		return Response::json(array('errCode'=>0,'message'=>'修改业务单价', 'account_info'=>$account_info['account'])) ;
	}

	//违章查询逻辑
	public function violation()
	{
		$data = array(
				//车牌号码
				'req_car_plate_no' 	=> Input::get('req_car_plate_no'),
				//发动机号码后6位
				'req_car_engine_no' => Input::get('req_car_engine_no'),
				//车架号码后6位
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
		
		$token = $this->token();
		$url = Config::get('domain.server').'/api/violation?token='.$token.
				'&licensePlate='.$data['req_car_plate_no'].'&engineCode='.
				$data['req_car_engine_no'].'&licenseType='.$data['car_type_no'];
		$violation = json_decode( CurlController::get($url), true );
		// $violation =  CurlController::get($url);
		
		if( $violation['errCode'] != 0)
		{
			Log::info( $violation );
			return $this->errMessage($violation['errCode']);
		}

		$violation = json_decode( $violation['data'],true);
		if(isset($violation['body'][0]['tips']))
			return Response::json(array('errCode'=>25, 'message'=>'车牌号码或号牌种类错误'));

		return Response::json(array('errCode'=>0, 'message'=>'获取车辆违章信息','violations'=>$violation['body']));
	}

	//查询驾驶证扣分信息
	public function license()
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
			return Response::json(array('errCode'=>1, 'message'=>'请填写完整的信息'));

		 $token = $this->token();
		 $url = Config::get('domain.server').'/api/license?token='.$token.'&identityID='.
		 					$data['identityID'].'&recordID='.$data['recordID'];
		 $license = json_decode( CurlController::get($url),true );
		
		 if( $license['errCode'] != 0 )
		 {
		 	Log::info( $license );
			return $this->errMessage($license['errCode']);
		 }
		 $license = json_decode( $license['data'],true);
		 
		 if($license['returnCode'] == 0)
		 {
		 	return Response::json(array('errCode'=>21,'message'=>'身份证号码，驾驶证号码或档案号码错误'));
		 }
		 $license = json_decode( $license['body'],true);

		 return Response::json(array('errCode'=>0, 'message'=>'驾驶证扣分分数','number'=>$license['ljjf']));
	}	


	//查询车辆信息
	public function car()
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
					return Response::json(array('errCode'=>1,'message'=>'信息填写不完整'));
					break;
				case 2:
					return Response::json(array('errCode'=>2,'message'=>'发动机后6位格式不正确'));
					break;
				case 3:
					return Response::json(array('errCode'=>3,'message'=>'车牌号码格式不正确'));
					break;
				default:
					return Response::json(array('errCode'=>4,'message'=>'车辆类型格式不正确'));
					break;
			}
		}

		$token = $this->token();
		$url = Config::get('domain.server').'/api/car?token='.$token.'&engineCode='.
		 					$data['engineCode'].'&licensePlate='.$data['licensePlate'].
		 					'&licenseType='.$data['licenseType'];
		$car = json_decode( CurlController::get($url),true );
			
		if( $car['errCode'] != 0 )
		{
			Log::info( $car );
			return $this->errMessage($car['errCode']);
		}
		$car = json_decode( $car['data'],true);
		// $car = $car['body'];
		if( $car['returnCode'] == 0)
			return Response::json(array('errCode'=>3, 'message'=>'没有车辆信息，请查看信息是否填写正确'));
		
		return Response::json(array('errCode'=>0, 'message'=>'车辆信息','car'=>$car['body']));
	}
}