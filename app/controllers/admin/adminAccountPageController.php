<?php

class AdminAccountPageController extends BaseController{

	//帐号信息
	public function changePassword()
	{
		$admin = Auth::user();

		return View::make('pages.admin.account.change-password', ["admin" => $admin]);
	}

	public function login()
	{
		return View::make('pages.admin.account.login');
	}
}