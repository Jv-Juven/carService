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

	//信息登记<<<<<<未测试>>>>>>
	public function informationRegister()
	{
		//手机验证码逻辑没写
		$checkcode	= Input::get('checkcode');

		$data = array(
			'user_id'						=> Input::get('user_id'),
			'business_name' 				=> Input::get('business_name'),
			'business_licence_no' 			=> Input::get('business_licence_no'),
			'business_licence_scan_path' 	=> Input::get('business_licence_scan_path'),
			'bank_account'					=> Input::get('bank_account'),
			'deposit_bank'					=> Input::get('deposit_bank'),
			'bank_outlets'					=> Input::get('bank_outlets'),
			'operational_name'				=> Input::get('operational_name'),
			'operational_card_no'			=> Input::get('operational_card_no'),
			'operational_phone'				=> Input::get('operational_phone'),
			''				=> Input::get(''),
			''				=> Input::get(''),
		);
		$rules = array(
			'user_id'						=> 	'required',
			'business_name' 				=>  'required',
			'business_licence_no' 			=>  'required',
			'business_licence_scan_path' 	=>  'required',
			'bank_account'					=>  'required',
			'deposit_bank'					=>  'required',
			'bank_outlets'					=>  'required',
			'operational_name'				=>  'required',
			'operational_card_no'			=>  'required',
			'operational_phone'				=>  'required',
			''				=>  'required',
			''				=>  'required',
		);
		$validation = Validator::make($data, $rules);

		if($validation->fails())
			return Response::json(array('errCode'=>1, 'message'=>'请填写完整信息'));
		try
		{
			DB::transaction(function() use( $data ) {
			 $business_user = new businessUser;
			 //主键
			 $business_user->user_id 					= $data['user_id'];
			 //企业名称
			 $business_user->business_name 				= $data['business_name'];
			 //营业执照号
			 $business_user->business_licence_no		= $data['business_licence_no'];
			 //营业执照扫描件存放位置
			 $business_user->business_licence_scan_path = $data['business_licence_scan_path'];
			 //企业银行账号	
			 $business_user->bank_account 				= $data['bank_account'];
			 //开户银行
			 $business_user->deposit_bank 				= $data['deposit_bank'];
			 //开户网点
			 $business_user->bank_outlets				= $data['bank_outlets'];
			 //运营人员姓名
			 $business_user->operational_name			= $data['operational_name'];
			 //运营人员身份证号码
			 $business_user->operational_card_no		= $data['operational_card_no'];
			 //运营人员身份证号码
			 $business_user->operational_phone			= $data['operational_phone'];
			 //身份证正面扫描件
			 // $business_user->			= $data[''];
			 //身份证反面扫描件
			 // $business_user->			= $data[''];
			 $business_user->save();
			 
			 $user = User::find($data['user_id']);
			 $user->status = 20;//信息审核中
			 $user->save();
			});
		}catch(\Exception $e)
		{
			return Response::json(array('errCode'=>11,'message'=>'操作失败' ));
		}
	return Response::json(array('errCode'=>0, 'message'=> '注册成功'));
	}

	//登录<<<<<<未测试>>>>>>>
	public function login()
	{
		$login_account 	= Input::get('login_account');
		$password 		= Input::get('password');
		// $tele_regex  	= Config::get('regex.telephone');
		// $email_regex 	= Config::get('regex.email');
		
		$login_user = User::where('login_account',$login_account)->first();
		if(!isset($login_user))
			return Response::json(array('errCode'=>1, 'message'=>'该用户为注册'));
		
		$cred = [
            'login_account'	=> $login_account,
            'password'		=> $password,
	        ];
        try
        {	
            $user = Sentry::authenticate($cred,false);
            if($user)
            {
            	switch ($user->status) {
            		case 10:
            			return Response::json(array('errCode'=>10,'message'=>'请激活邮箱'));
            			break;
            		case 11:
            			return Response::json(array('errCode'=>11,'message'=>'请填写登记信息'));
            			break;
        			case 20:
            			return Response::json(array('errCode'=>20,'message'=>'信息审核中'));
	        			break;
        			case 21:
            			return Response::json(array('errCode'=>21,'message'=>'请填写备注码'));
	        			break;
        			case 30:
            			return Response::json(array('errCode'=>30,'message'=>'账户已被锁定'));
	        			break;
            		default:
            			return Response::json(array('errCode'=>0,'message'=>'登录成功'));
            			break;
            	}
            }
        }catch (\Exception $e){
            return Response::json(array('errCode'=>1,'message'=>$e->getMessage()));
        }
	}

	//意外退出后发送验证信息<<<<<<未测试>>>>>>>
	public function sendTokenToEmail()
	{
		$login_account = Input::get('login_account');
		$token = rand(111111,999999);
		//发送邮件
		Mail::send('emails/token',array('token' => $token),function($message) use ($data)
		{
			$message->to($data['login_account'],'')->subject('车尚车务系统!');
		});
		$user = User::where('login_account',$login_account)->first();
		//储存数据
		Cache::put('token',$token,5);
		Cache::put('user_id',$user->user_id,5);

		return Response::json(array('errCode'=>0, 'message'=>'验证码发送成功!'));
	}


}
