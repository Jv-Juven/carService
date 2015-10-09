<?php

class AdminAccountPageController extends BaseController{

	//帐号信息
	public function changePassword()
	{
		return View::make('pages.admin.account.change-password');
	}

	public function login()
	{
		return View::make('pages.admin.account.login');
	}
}