<?php

class AdminBusinessCenterPageController extends BaseController{

	// 新用户列表
	public function newUserList()
	{
		$newUsers = User::where("status", "=", "20")->with("business_info")->paginate(10);

		$totalCount = $newUsers->getTotal();
		$count = $newUsers->count();

		return View::make('pages.admin.business-center.new-user-list', [
			"count" => $count,
			"newUsers" => $newUsers,
			"totalCount" => $totalCount
		]);
	}

	// 企业用户信息
	public function userInfo()
	{
		$user_id = Input::get("user_id");

		$user = User::where("user_id", "=", $user_id)->with("business_info")->get();

		if(!count($user))
			return View::make("errors.user-missing");

		return View::make('pages.admin.business-center.user-info', [
			"user" => $user[0]
		]);
	}

	// 企业用户列表
	public function userList()
	{
		$type = Input::get("type", "all");
		$perPage = 15;

		if($type === "all") {
			$users = User::where("user_type", "=", "1")->with("business_info")->paginate($perPage);
		} else if($type === "actived") {
			$users = User::where("user_type", "=", "1")->where("status", "=", "22")->with("business_info")->paginate($perPage);
		} else if($type === "unactived") {
			$users = User::where("user_type", "=", "1")->where("status", "=", "21")->with("business_info")->paginate($perPage);
		} else if($type === "unchecked") {
			$users = User::where("user_type", "=", "1")->where("status", "=", "20")->with("business_info")->paginate($perPage);
		} else if($type === "locked") {
			$users = User::where("user_type", "=", "1")->where("status", "=", "30")->with("business_info")->paginate($perPage);
		} else {
			$type = "others";
			$users = User::where("user_type", "=", "1")->where("status", "<>", "20")->where("status", "<>", "21")->where("status", "<>", "22")->where("status", "<>", "30")->with("business_info")->paginate($perPage);
		}

		$totalCount = $users->getTotal();
		$count = $users->count();

		return View::make('pages.admin.business-center.user-list', [
			"users" => $users,
			"count" => $count,
			"totalCount" => $totalCount
		]);
	}

	// 搜索企业用户
	public function searchUser()
	{
		return View::make('pages.admin.business-center.search-user');
	}

	// 审核企业用户
	public function checkNewUser()
	{
		$userId = Input::get("user_id");

		$user = User::where("user_id", "=", $userId)->with("business_info")->get();

		if(count($user) == 0)
			return View::make("errors.user-missing");

		return View::make('pages.admin.business-center.check-new-user', [
			"user" => $user[0]
		]);
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
		$violationUnivalence = DB::table('fee_types')->select('number')->where("category", "20")->where("item", "2")->first();
	    $licenseUnivalence = DB::table('fee_types')->select('number')->where("category", "20")->where("item", "1")->first();
	    $carUnivalence = DB::table('fee_types')->select('number')->where("category", "30")->where("item", "2")->first();

	    

		return View::make('pages.admin.business-center.change-default-query-univalence', [
			"companyExpressUnivalence" => $companyExpressUnivalence->number,
			"personExpressUnivalence" => $personExpressUnivalence->number,
			"companyAgencyUnivalence" => $companyAgencyUnivalence->number,
			"personAgencyUnivalence" => $personAgencyUnivalence->number
		]);
	}

	// 
	public function changeDefaultServiceUnivalence()
	{
		$companyExpressUnivalence = DB::table('fee_types')->select('number')->where("category", "20")->where("item", "2")->first();
	    $personExpressUnivalence = DB::table('fee_types')->select('number')->where("category", "20")->where("item", "1")->first();
	    $companyAgencyUnivalence = DB::table('fee_types')->select('number')->where("category", "30")->where("item", "2")->first();
	    $personAgencyUnivalence = DB::table('fee_types')->select('number')->where("category", "30")->where("item", "1")->first();

		return View::make('pages.admin.business-center.change-default-service-univalence', [
			"companyExpressUnivalence" => $companyExpressUnivalence->number,
			"personExpressUnivalence" => $personExpressUnivalence->number,
			"companyAgencyUnivalence" => $companyAgencyUnivalence->number,
			"personAgencyUnivalence" => $personAgencyUnivalence->number
		]);
	}
}






