<?php

class AdminAccountPageController extends BaseController{

	//帐号信息
	public function userInfo()
	{
		return View::make('pages.admin.admin-account.admin-account');
	}
}