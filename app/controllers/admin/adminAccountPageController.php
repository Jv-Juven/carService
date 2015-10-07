<?php

class adminAccountPageController extends BaseController{

	//帐号信息
	public function index()
	{
		return View::make('pages.admin.admin-account.admin-account');
	}
}