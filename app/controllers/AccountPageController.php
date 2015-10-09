<?php

class AccountPageController extends BaseController{

	//帐号信息
	public function accountInfo()
	{
		return View::make('pages.account-center.account-info');
	}

	//开发者中心
	public function developerInfo()
	{
		return View::make('pages.account-center.developer-info');
	}
}