<?php

class UserPageController extends BaseController{

	//<<<<<<<B端用户邮箱注册页>>>>>>>
	public function bSiteRegisterPage()
	{
		return View::make('pages.register-b.baseinfo');
	}

	//B端用户邮箱注册验证通过后跳转到<<<<<<<邮箱激活页面>>>>>>>>
	public function emailActivePage()
	{
		return View::make('pages.register-b.email-active');
	}

	//信息登记
	public function infomationRegisterPage()
	{
		return View::make('pages.register-b.reg-info');
	}

	//发到B端用户邮箱后，点击链接验证，通过后去到信息登记页
	public function isEmailActive()
	{
		$token = Input::get('token');
		$user = Cache::get($token);
		
		if(!isset($user))
		{
			//登录后发邮件去邮箱验证邮箱
			return View::make('errors.re-send');
		}
		$status = User::find( $user->user_id )->status;
		// switch ( $status ) {
		// 		case 11:
		// 			return View::make('pages.register-b.reg-info');//信息登记
		// 		case 20:
		// 			return View::make('pages.account-status.no-pass-words');//您的帐号正在审核中，请耐心等候！
		// 		case 21:
		// 			return View::make('pages.account-status.write-codes');//填写打款备注码页面
		// 		case 22:
		// 			return View::make('pages.serve-center.data.violation');
		// 		case 30:
		// 			return View::make('errors.lock');//帐号锁定页面
		// }
		if( $status != 10)
		{
			return View::make('errors.re-send');
		}
		if( Sentry::check() )
		{
			//将状态信息改成未填写登记信息
			$user->status = 11;
			$user->save();
		}else{
			Sentry::login($user,false);
			$user->status = 11;
			$user->save();	
		}
		
		return View::make('pages.register-b.reg-info');
	}

	//审核
	public function pending()
	{
		return View::make('pages.register-b.success');
	}


	//锁定页面
	public function lock()
	{
		return View::make('errors.lock');
	}

	//审核不通过
	public function noPass()
	{
		return View::make('pages.account-status.no-pass');
	}

	//打款验证码
	public function writeCode()
	{
		return View::make('pages.account-status.write-codes');
	}

	public function noPassword()
	{
		return View::make('pages.account-status.no-pass-words');
	}

}
