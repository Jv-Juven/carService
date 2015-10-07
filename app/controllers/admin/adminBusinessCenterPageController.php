<?php

class adminBusinessCenterPageController extends BaseController{

	// 新用户列表
	public function newUserList()
	{
		return View::make('pages.admin.business-center.new-user-list');
	}

	// 企业用户信息
	public function userInfo()
	{
		return View::make('pages.admin.business-center.user-info');
	}

	// 企业用户列表
	public function userList()
	{
		return View::make('pages.admin.business-center.user-list');
	}

	// 搜索企业用户
	public function searchUser()
	{
		return View::make('pages.admin.business-center.search-user');
	}

	// 审核企业用户
	public function checkNewUser()
	{
		return View::make('pages.admin.business-center.check-new-user');
	}

	// 
	public function changeUserStatus()
	{
		return View::make('pages.admin.business-center.change-user-status');
	}

	// 
	public function changeQueryUnivalence()
	{
		return View::make('pages.admin.business-center.change-query-univalence');
	}

	// 
	public function changeServiceUnivalence()
	{
		return View::make('pages.admin.business-center.change-service-univalence');
	}

	// 
	public function changeDefaultQueryUnivalence()
	{
		return View::make('pages.admin.business-center.change-default-query-univalence');
	}

	// 
	public function changeDefaultServiceUnivalence()
	{
		return View::make('pages.admin.business-center.change-default-service-univalence');
	}
}






