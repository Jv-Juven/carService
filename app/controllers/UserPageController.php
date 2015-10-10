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
		$login_account = Input::get('login_account');
		return View::make('pages.register-b.email-active')->with(array('login_account'=>$login_account));
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

		// 验证不通过，过期重新填写，回到邮箱注册页
		if(!isset($user))
		{
			//登录后发邮件去邮箱验证邮箱
			return View::make('pages.register-b.email-active');
		}

		//将状态信息改成未填写登记信息
		Sentry::login($user,false);
		$user->status = 11;
		$user->save();
		
		//验证通过，回到信息登记页
		// return '成功';
		return View::make('pages.register-b.reg-info');
	}

	//审核
	public function pending()
	{
		return View::make('pages.register-b.sueecss');
	}

	//打款码填写静态页面
	public function remarkCode()
	{
		return View::make('');
	}
}