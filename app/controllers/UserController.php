<?php
use Gregwar\Captcha\CaptchaBuilder;

class UserController extends BaseController{

	//生成固定长度	随机字符串
	public function randNumber()
	{
		$possible_charactors = "abcdefghijklmnopqrstuvwxyz0123456789"; //产生随机数的字符串
		$salt  =  "";   //验证码
		while(strlen($salt) < 6)
		{
		 	 $salt .= substr($possible_charactors,rand(0,strlen($possible_charactors)-1),1);
		}
		return $salt;
	}

	//发送手机验证码
	public function messageVerificationCode($phone)
	{
		$url = Config::get('domain.phone.url');
		$username = Config::get('domain.phone.username');
		$password = Config::get('domain.phone.password');
		
		$text_number = $this->randNumber();
		$text = urlencode( iconv('UTF-8', 'GBK','车尚服务验证码:'.$text_number));
		// dd($text);
		Session::put('phone_code',$text_number);
		
		$parm = 'username='.$username.'&password='.$password.'&to='.$phone.
		'&text='.$text.'&msgtype=1';
		$req = CurlController::get($url.'?'.$parm);
		switch ($req) {
			case ""://正常时返回空，妈蛋儿！
				return Response::json(array('errCode'=> 0, 'message'=> '正常发送'));
			case "-2":
				return Response::json(array('errCode'=> -2, 'message'=> '发送参数填写不正确'));
			case "-3":
				return Response::json(array('errCode'=> -3, 'message'=> '用户载入延迟'));
			case "-6":
				return Response::json(array('errCode'=> -6, 'message'=> '密码错误'));
			case "-7":
				return Response::json(array('errCode'=> -7, 'message'=> '用户不存在'));
			case "-11":
				return Response::json(array('errCode'=> -11, 'message'=> '发送号码数理大于最大发送数量'));
			case "-12":
				return Response::json(array('errCode'=> -12, 'message'=> '余额不足'));
			case "-99":
				return Response::json(array('errCode'=> -99, 'message'=> '内部处理错误'));
			default:
				return Response::json(array('errCode'=>  21, 'message'=> '未知错误'));
		}
	}

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

	//C端用户根据手机获取验证码
	public function getPhoneCode()
	{
		$login_account 			= Input::get('login_account');
		$phone_regex 	= Config::get('regex.telephone');
		if(!preg_match($phone_regex, $login_account))
			return Response::json(array('errCode'=>21,'message'=>'手机号码格式不正确'));
		
		//是否注册
		$user = User::where('login_account',$login_account)->first();
		if(isset($user))
			return Response::json(array('errCode'=>22, 'message'=>'该用户已注册'));
		
		//发送验证码
		$number = $this->messageVerificationCode($login_account);
		if($number->getData()->errCode != "")
			return Response::json(array('errCode'=>23, 'message'=>'发送太过频繁，请稍候再试，如不能发送，请及时与客户联系'));

		return Response::json(array('errCode'=>0,'message'=>'验证码发送成功'));
	}

	//C端用户注册
	public function cSiteRegister()
	{
		$data = array(
			'login_account' 	=> Input::get('login_account'),
			'password' 			=> Input::get('password'),
			're_password' 		=> Input::get('re_password'),
			'phone_code'		=> Input::get('phone_code'),
		);
		$session_phone_code = Session::get('phone_code');
		$rules = array(
			'login_account' => 'required|size:11|unique:users,login_account',
			'password'		=> 'required|alpha_num|between:6,16',
			're_password' 	=> 'required|same:password',
			'phone_code'	=> 'required|size:6'
		);
		$messages = array(
			'login_account.required' => 1,
			'password.required' 	 => 1,
			're_password.required' 	 => 1,
			'phone_code.required'    => 1,
			'login_account.size' 	 => 2,
			'login_account.unique'	 => 3,
			'password.alpha_num' 	 => 4,
			'password.between' 		 => 5,
			're_password.same' 		 => 6,
			'phone_code.size' 		 => 7, 
		);
		
		$validation = Validator::make($data,$rules,$messages);
		if($validation->fails())
		{
			$number = $validation->messages()->all();
			switch ($number[0]) {
				case 1:
					return Response::json(array('errCode'=>21,'message'=>'请将信息填写完整'));
				case 2:
					return Response::json(array('errCode'=>22,'message'=>'手机号码位数不正确'));
				case 3:
					return Response::json(array('errCode'=>23,'message'=>'该用户已注册'));
				case 4:
					return Response::json(array('errCode'=>24,'message'=>'密码必须为数字和字母组成'));
				case 5:
					return Response::json(array('errCode'=>25,'message'=>'密码必须在6到16位之间'));
				case 6:
					return Response::json(array('errCode'=>26,'message'=>'两次输入的密码不一致'));
				default:
					return Response::json(array('errCode'=>27,'message'=>'手机验证码位数不对'));
			}
		}
		if($data['phone_code'] != $session_phone_code)
			return Response::json(array('errCode'=>26,'message'=>'手机验证码不对，请重新输入'));
		try
			{
				$user = Sentry::createUser(array(
			        'login_account'     => $data['login_account'],
			        'password'  		=> $data['password'],
			        // 'user_id'			=> 'yhxx'.uniqid(),
			        'user_type'			=> 0,
			        'status'			=> 22,
			    ));
			}
		catch(Cartalyst\Sentry\Users\UserExistsException $e)
		{
			return Response::json(array('errCode'=>7,'message'=>'该用户已存在'));
		}
		
		// $user = User::where('login_account',$user->login_account)->first();
		// Sentry::login($user,false);

		return Response::json(array('errCode'=>0, 'message'=>'注册成功'));
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
			case 2:
				return Response::json(array('errCode'=>2, 'message'=>'邮箱已被注册！'));
			case 3:
				return Response::json(array('errCode'=>3, 'message'=>'邮箱格式不正确！'));
			case 4:
				return Response::json(array('errCode'=>4, 'message'=>'密码只能包含字母和数字！'));
			case 5:
				return Response::json(array('errCode'=>5, 'message'=>'密码必须是6到20位之间！'));
			case 6:
				return Response::json(array('errCode'=>6, 'message'=>'两次密码输入不一致！'));
			default:
				return Response::json(array());
			}
		}else{
			
			$token = md5($data['login_account'].time());
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
			$user = User::where('login_account',$user->login_account)->first();
			Sentry::login($user,false);
			Cache::put($token,$token,5);
			Cache::put('user_id',$user->user_id,5);
			// var_dump($user->user_id);
			
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
			'id_card_front_scan_path'		=> Input::get('id_card_front_scan_path'),
			'id_card_back_scan_path'		=> Input::get('id_card_back_scan_path'),
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
			'id_card_front_scan_path'		=>  'required',
			'id_card_back_scan_path'		=>  'required',
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
			 //运营人员电话号码
			 $business_user->operational_phone			= $data['operational_phone'];
			 //身份证正面扫描件
			 $business_user->id_card_front_scan_path	= $data['id_card_front_scan_path'];
			 //身份证反面扫描件
			 $business_user->id_card_back_scan_path		= $data['id_card_back_scan_path'];
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
            		case 11:
            			return Response::json(array('errCode'=>11,'message'=>'请填写登记信息'));
        			case 20:
            			return Response::json(array('errCode'=>20,'message'=>'信息审核中'));
        			case 21:
            			return Response::json(array('errCode'=>21,'message'=>'请填写备注码'));
        			case 30:
            			return Response::json(array('errCode'=>30,'message'=>'账户已被锁定'));
            		default:
            			return Response::json(array('errCode'=>0,'message'=>'登录成功'));
            	}
            }
        }catch (\Exception $e){
            return Response::json(array('errCode'=>1,'message'=>'账户或密码错误'.$e->getMessage()));
        }
	}

	//意外退出后发送验证信息<<<<<<未测试>>>>>>>
	public function sendTokenToEmail()
	{
		$login_account = Input::get('login_account');
		$user = User::where('login_account',$login_account)->first();

		if(!isset($user))
			return Response::json(array('errCode'=>1,'message'=>'该用户没注册'));

		$token = md5($data['login_account'].time());
		//发送邮件
		Mail::send('emails/token',array('token' => $token),function($message) use ($data)
		{
			$message->to($data['login_account'],'')->subject('车尚车务系统!');
		});
		$user = User::where('login_account',$login_account)->first();
		//储存数据
		Cache::put($token,$user->user_id,5);

		return Response::json(array('errCode'=>0, 'message'=>'验证码发送成功!'));
	}
	
	//c端用户修改密码－发送验证码到手机
	public function  sendResetCodeToPhone()
	{
		$login_account = Sentry::getUser()->login_account;		
		$input = Input::get('login_account');
		if($input != $login_account)
			return Response::json(array('errCode'=>21, 'message'=>'手机号码错误，请重新输入'));

		//发送验证码
		$number = $this->messageVerificationCode($login_account);
		if($number->getData()->errCode != "")
			return Response::json(array('errCode'=>22, 'message'=>'发送太过频繁，请稍候再试，如不能发送，请及时与客户联系'));

		return Response::json(array('errCode'=>0,'message'=>'验证码发送成功'));
	}

	//c端用户修改密码－重置密码
	public function resetCustomerSitePassword()
	{
		//验证码验证
		$phone_code 		= Input::get('phone_code');
		$session_phone_code = Session::get('phone_code');
		if( $phone_code != $session_phone_code)
			return Response::json(array('errCode'=>21,'message'=>'验证码不正确'));

		//手机号验证
		$login_account 	= Input::get('login_account');
		$user = Sentry::getUser();
		if($login_account != $user->login_account)
			return Response::json(array('errCode'=>22,'message'=>'手机号码不正确，请重新输入'));
		
		$data = array(
			'password' 	   => Input::get('password'),
			're_password'   => Input::get('re_password')
		);
		
		$rules = array(
			'password'      =>'required|alpha_num|between:6,16',
			're_password' 	=>'required|same:password'
		);

		$messages = array(
			'password.required' 	    => 1,
			're_password.required' 		=> 1,
			'password.alpha_num'   		=> 2,
			'password.between'      	=> 3,
			're_password.same'     		=> 4
		);

		$validation = Validator::make($data, $rules,$messages);

		if($validation->fails()) 
		{	//获得错误信息数组
			$number = $validation->messages()->all();
			switch ($number[0])
			{
			case 1:
				return Response::json(array('errCode'=> 21, 'message'=>'信息填写不完整！')); 
			case 2:
				return Response::json(array('errCode'=> 22, 'message'=>'密码只能包含字母和数字！'));
			case 3:
				return Response::json(array('errCode'=> 23, 'message'=>'密码必须是6到20位之间！'));
			default:
				return Response::json(array('errCode'=> 24, 'message'=>'两次密码输入不一致！'));
			}
		}
		//重置密码
		$user = Sentry::findUserById($user->user_id);
		$resetCode = $user->getResetPasswordCode();
		if(!$user->attemptResetPassword($resetCode, $data['password']))
			return Response::json(array('errCode' => 25,'message' => '重置密码失败!'));
		
		return Response::json(array('errCode' => 0,'message' => '重置密码成功!'));
	}

	//b端用户修改密码－发送验证码到邮箱
	public function sendResetCodeToEmail()
	{	
		$login_account = Input::get('login_account');
		$user = Sentry::findUserByLogin(Sentry::getUser()->login_account);
		if($login_account != $user->login_account)
			return Response::json(array('errCode'=>21, 'message'=> '邮箱不正确'));

		try
		{	
		    $user = Sentry::findUserByLogin(Sentry::getUser()->login_account);
		    $reset_code = $user->getResetPasswordCode();

		    //发送邮件
			Mail::send('emails/resetcode',array('reset_code' => $reset_code),function($message) use ($user)
			{
				$message->to($user->login_account,'')->subject('车尚车务系统!');
			});
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Response::json(array('errCode'=>22,'message'=>'该用户不存在'));
		}

		return Response::json(array('errCode'=>0, 'message'=>'重置验证码发送成功'));
	}

	//b端用户修改密码－重置密码
	public function resetBusinessSitePassword()
	{
		$user = Sentry::getUser();
		$reset_code = Input::get('reset_code');
		
		$data = array(
			'password' 	   => Input::get('password'),
			're_password'   => Input::get('re_password')
		);
		
		$rules = array(
			'password'      =>'required|alpha_num|between:6,16',
			're_password' 	=>'required|same:password'
		);

		$messages = array(
			'password.required' 	    => 1,
			're_password.required' 		=> 1,
			'password.alpha_num'   		=> 2,
			'password.between'      	=> 3,
			're_password.same'     		=> 4
		);

		$validation = Validator::make($data, $rules,$messages);

		if($validation->fails()) 
		{	//获得错误信息数组
			$number = $validation->messages()->all();
			switch ($number[0])
			{
			case 1:
				return Response::json(array('errCode'=> 21, 'message'=>'信息填写不完整！')); 
			case 2:
				return Response::json(array('errCode'=> 22, 'message'=>'密码只能包含字母和数字！'));
			case 3:
				return Response::json(array('errCode'=> 23, 'message'=>'密码必须是6到20位之间！'));
			default:
				return Response::json(array('errCode'=> 24, 'message'=>'两次密码输入不一致！'));
			}
		}
		//重置密码
		try
		{
		    $user = Sentry::findUserById($user->user_id);

		    if ($user->checkResetPasswordCode($reset_code))
		    {
		        // Attempt to reset the user password
		        if ($user->attemptResetPassword($reset_code, $data['password']))
		        {
		            return Response::json(array('errCode'=>0, 'message'=>'重置密码成功'));
		        }
		        else
		        {
		            return Response::json(array('errCode'=>25, 'message'=>'重置密码失败'));
		        }
		    }
		    else
		    {
	            return Response::json(array('errCode'=>26, 'message'=>'验证码不正确'));
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
            return Response::json(array('errCode'=>27, 'message'=>'该用户不存在'));
		}
	}

	//获取每个user_id 对应的 appkey和secretkey
	public function app()
	{
		$user_id = Sentry::getUser()->user_id;
		//构建获取appkey的链接
		$url = Config::get('domain.server').'/app?uid='.$user_id;
		$data = json_decode( CurlController::get($url),true );
		// dd($data);
		
		if($data['errCode'] != 0 )
		{	
			Log::info($data);
			return parent::errMessage($data['errCode']);
		}

		//向用户表中存入appkey
		$business_user = BusinessUser::find(Sentry::getUser()->user_id);
		$business_user->app_key = $data['app']['appkey'];
		$business_user->app_secret = $data['app']['secretkey'];
		if(!$business_user->save())
			return Response::json(array('errCode'=>11, 'message'=>'获取appkey失败，请重新获取'));
		
		return Response::json(array('errCode'=>0, 'message'=>'appkey获取成功'));	

	}
}
