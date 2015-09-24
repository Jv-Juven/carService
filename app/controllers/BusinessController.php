<?php

class BusinessController extends BaseController{

	//充值
	public function recharge()
	{
		$money = Input::get('money');
		if( !isset($money) )
			return Response::json(array('errCode'=>1, 'message'=>'请填写充值金额'));

		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account/recharge';
		$parm = 'appkey='.urlencode( $appkey ).'&money='.urlencode( $money );

		//充值
		// $recharge =json_decode( CurlController::post($url,$parm), true);
		$recharge =  CurlController::post($url,$parm);
		return $recharge;
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
				'req_car_frame_no' 	=> Input::get('req_car_frame_no')
			);
		$rules = array(
				'req_car_plate_no' 	=> 'required|size:7',
				'req_car_engine_no' => 'required|size:6',
				'req_car_frame_no' 	=> 'required|size:2'
			);

		$messages = array(
				'req_car_plate_no.required'  => 1,
				'req_car_engine_no.required' => 1,
				'req_car_frame_no.required'  => 1,
				'req_car_plate_no.size'		 => 2, 
				'req_car_engine_no.size'	 => 3,
				'req_car_frame_no.size'		 => 4
			);

		$validation = Validator::make($data, $rules,$messages);
		if($validation->fails())
		{
			$number = $validation->messages()->all();
			switch ($number[0]) {
				case 1:
					return Response::json(array('errCode'=>1, 'message'=>'请将信息填写完整'));
					break;
				case 2:
					return Response::json(array('errCode'=>2, 'message'=>'车牌号码位数不正确'));
					break;
				case 3:
					return Response::json(array('errCode'=>3, 'message'=>'发动机号码位数不正确'));
					break;
				default:
					return Response::json(array('errCode'=>4, 'message'=>'车架号码位数不正确'));
					break;
			}
		}
		
		$token = $this->token();
		$url = Config::get('domain.server').'/api/violation?token='.$token.
				'&licensePlate='.$data['req_car_plate_no'].'&engineCode='.
				$data['req_car_engine_no'].'&licenseType='.$data['req_car_frame_no'];
		$violation = json_decode( CurlController::get($url), true);

		return $violation;

	}
}