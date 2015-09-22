<?php
use Gregwar\Captcha\CaptchaBuilder;

class UserController extends BaseController{

	//生成验证码(congcong网)
	public function captcha()
	{	
		session_start();
		$builder = new CaptchaBuilder;
		$builder->build();
		$_SESSION['phrase'] = $builder->getPhrase();
		header("Cache-Control: no-cache, must-revalidate");
		header('Content-Type: image/jpeg');
		$builder->output();
		exit;
	}

	//C端用户注册
	public function cSiteRegister()
	{

	}

	//B端用户注册
	public function bSiteRegister()
	{
		Session_start();
		$captcha = Input::get('captcha');
		if( $captcha != $_SESSION['phrase'])
			return Response::json(array('errCode'=>8, 'message'=> '验证码不正确'));
		$data = array(
			'login_account' => Input::get('login_account'),//邮箱
			'password'      => Input::get('password'),
			're_password'   => Input::get('re_password')
		);

		$rules = array(
			'login_account' =>'required|email|unique:users,login_account',
			'password'      =>'required|alpha_num|between:6,16',
			're_password' 	=>'required|same:password'
		);
		$messages = array(
			'login_account.required'    => 1,
			'password.required' 	    => 1,
			're_password.required' 		=> 1,
			'login_account.unique'      => 2,
			'login_account.email'       => 3,
			'password.alpha_num'   		=> 4,
			'password.between'      	=> 5,
			're_password.same'     		=> 6
		);

		$validation = Validator::make($data, $rules,$messages);

		if($validation->fails()) 
		{	//获得错误信息数组
			$number = $validation->messages()->all();
			switch ($number[0])
			{
			case 1:
				return Response::json(array('errCode'=>1, 'message'=>'信息填写不完整！')); 
				break;
			case 2:
				return Response::json(array('errCode'=>2, 'message'=>'邮箱已被注册！'));
				break;
			case 3:
				return Response::json(array('errCode'=>3, 'message'=>'邮箱格式不正确！'));
				break;
			case 4:
				return Response::json(array('errCode'=>4, 'message'=>'密码只能包含字母和数字！'));
				break;
			case 5:
				return Response::json(array('errCode'=>5, 'message'=>'密码必须是6到20位之间！'));
				break;
			case 6:
				return Response::json(array('errCode'=>6, 'message'=>'两次密码输入不一致！'));
				break;
			default:
				return Response::json(array());

			}
		}else{
			$token = rand(111111,999999);
			//发送邮件
			Mail::send('emails/token',array('token' => $token),function($message) use ($data)
			{
				$message->to($data['login_account'],'')->subject('车尚车务系统!');
			});
			
			try
			{
				$user = Sentry::createUser(array(
			        'login_account'     => $data['login_account'],
			        'password'  		=> $data['password'],
			        // 'user_id'			=> 'yhxx'.uniqid(),
			        'user_type'			=> 1,
			        'status'			=> 10,
			        'activated' 		=> false,
			    ));
			}
			catch(Cartalyst\Sentry\Users\UserExistsException $e)
			{
				return Response::json(array('errCode'=>7,'message'=>'该用户已存在'));
			}
			//储存数据
			Cache::put('token',$token,5);
			Cache::put('user_id',$user->user_id,5);

			return Response::json(array('errCode'=>0, 'message'=>'验证码发送成功!'));
		}
	}

	//信息登记
	public function informationRegister()
	{
		$data = array(
			'user_id'						=> Input::get('user_id'),
			'business_name' 				=> Input::get('business_name'),
			'business_licence_no' 			=> Input::get('business_licence_no'),
			'business_licence_scan_path' 	=> Input::get('business_licence_scan_path'),
			'对公账户'						=> Input::get(''),
			'对公账户'						=> Input::get(''),
			'对公账户'						=> Input::get(''),
			'对公账户'						=> Input::get(''),
			'operational_name'				=> Input::get('operational_name'),
			'operational_card_no'			=> Input::get('operational_card_no'),
			'operational_phone'				=> Input::get('operational_phone'),
			'checkcode'						=> Input::get('checkcode')
		);
		$rules = array(
			'user_id'						=> Input::get('user_id'),
			'business_name' 				=>  'required',
			'business_licence_no' 			=>  'required',
			'business_licence_scan_path' 	=>  'required',
			'对公账户'						=>  'required',
			'对公账户'						=>  'required',
			'对公账户'						=>  'required',
			'对公账户'						=>  'required',
			'operational_name'				=>  'required',
			'operational_card_no'			=>  'required',
			'operational_phone'				=>  'required',
			'checkcode'						=>  'required',
		);
		$validation = Validator::make($data, $rules);

		if($validation->fails())
			return Response::json(array('errCode'=>1, 'message'=>'请填写完整信息'));
		 $business_user = new businessUser;
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->
		 $business_user->


	}
}
