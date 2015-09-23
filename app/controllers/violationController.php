<?php

class violationController extends BaseController{

	//违章查询逻辑
	public function inquire()
	{
		$data = array(
				'req_car_plate_no' 	=> Input::get('req_car_plate_no');
				'req_car_engine_no' => Input::get('req_car_engine_no');
				'req_car_frame_no' 	=> Input::get('req_car_frame_no');
			);
		$rules = array(
				'req_car_plate_no' 	=> 'required|size:8',
				'req_car_engine_no' => 'required|size:6',
				'req_car_frame_no' 	=> 'required|size:6'
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
		
	}
}