<?php

class adminBusinessCenterPageController extends BaseController{

	//帐号信息
	public function all()
	{
		return View::make('pages.account-center.account-info');
	}
}