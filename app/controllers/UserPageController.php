<?php

class UserPageController extends BaseController{

	//<<<<<<<B端用户邮箱注册页>>>>>>>
	public function bSiteRegisterPage()
	{
		return View::make('');
	}

	//B端用户邮箱注册验证通过后跳转到<<<<<<<邮箱激活页面>>>>>>>>
	public function emailActivePage()
	{
		$login_account = Input::get('login_account');
		return View::make('emails.active')->with(array('login_account'=>$login_account));
	}

	//信息登记
	public function infomationRegisterPage()
	{
		return View::make('');
	}

	//发到B端用户邮箱后，点击链接验证，通过后去到信息登记页
	public function isEmailActive()
	{
		$token = Input::get('token');
		$cache_token = Cache::get('token');
		// 验证不通过，过期重新填写，回到邮箱注册页
		if($token != $cache_token)
		{
			return '失败';
			// return View::make('');
		}
		//将状态信息改成未填写登记信息
		$user_id = Cache::get('user_id');
		$user = User::where('user_id',$user_id)->first();
		$user->status = 11;
		$user->save();
		//验证通过，回到信息登记页
		return '成功';
		// return View::make('')->with(array('user_id',$user->user_id));
	}

	//打款码填写静态页面
	public function remarkCode()
	{
		return View::make('');
	}
}