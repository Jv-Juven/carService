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

	// 修改用户状态
	public function changeUserStatus()
	{
		$userId = Input::get("user_id");
		$user = User::where("user_id", "=", $userId)->with("business_info")->first();

		return View::make('pages.admin.business-center.change-user-status', [
			"userId" => $userId,
			"status" => $user->status,
			"name" => $user->business_info->business_name
		]);
	}

	public function searchIndent()
	{
		$type = Input::get("type", "id");

		return View::make('pages.admin.business-center.search-indent', [
			"type" => $type
		]);
	}

	public function indentList()
	{
		$type = Input::get("type", "all");

		$perPage = 15;

		if($type == "untreated")
			$indents = AgencyOrder::where("process_status", "=", "0")->orderBy("created_at")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "treated")
			$indents = AgencyOrder::where("process_status", "=", "1")->orderBy("created_at")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "treating")
			$indents = AgencyOrder::where("process_status", "=", "2")->orderBy("created_at")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "finished")
			$indents = AgencyOrder::where("process_status", "=", "3")->orderBy("created_at")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "closed")
			$indents = AgencyOrder::where("process_status", "=", "4")->orderBy("created_at")->with("traffic_violation_info")->paginate($perPage);
		else
			$indents = AgencyOrder::orderBy("created_at")->with("traffic_violation_info")->paginate($perPage);

		return View::make('pages.admin.business-center.indent-list', [
			"indents" => $indents,
			"count" => $indents->count(),
			"totalCount" => $indents->getTotal()
		]);
	}

	// 修改特定企业用户查询价格
	public function changeQueryUnivalence()
	{
		$userId = Input::get("user_id");

		$user = BusinessUser::where("user_id", "=", $userId)->get();

		try 
		{
			$accountInfo = BusinessController::accountInfo($userId);
			$result = BusinessController::get_default_univalence();
		} 
		catch (Exception $e) 
		{
			return View::make('errors.page-error');
		}		

		return View::make('pages.admin.business-center.change-query-univalence', [
			"userId" => $userId,
			"username" => $user[0]->business_name,
			"violationUnivalence" => $accountInfo["violationUnit"],
			"defaultViolationUnivalence" => $result["violation"],
			"licenseUnivalence" => $accountInfo["licenseUnit"],
			"defaultLicenseUnivalence" => $result["license"],
			"carUnivalence" => $accountInfo["carUnit"],
			"defaultCarUnivalence" => $result["car"]
		]);
	}

	// 修改特定企业用户服务价格
	public function changeServiceUnivalence()
	{
		$userId = Input::get("user_id");
		
		$user = BusinessUser::where("user_id", "=", $userId)->get();

		$agencyUnivalence = BusinessController::getServiceFee($userId);
		$expressUnivalence = BusinessController::getExpressFee($userId);
	    $defaultAgencyUnivalence = DB::table('fee_types')->select('number')->where("category", "30")->where("item", "1")->first();
		$defaultExpressUnivalence = DB::table('fee_types')->select('number')->where("category", "20")->where("item", "1")->first();

		return View::make('pages.admin.business-center.change-service-univalence', [
			"defaultExpressUnivalence" => $defaultExpressUnivalence->number,
			"defaultAgencyUnivalence" => $defaultAgencyUnivalence->number,
			"expressUnivalence" => $expressUnivalence,
			"agencyUnivalence" => $agencyUnivalence,
			"username" => $user[0]->business_name,
			"userId" => $userId
		]);
	}

	// 修改默认查询价格
	public function changeDefaultQueryUnivalence()
	{
		try 
		{
			$result = BusinessController::get_default_univalence();
		} 
		catch (Exception $e) 
		{
			return View::make('errors.page-error');
		}		


		return View::make('pages.admin.business-center.change-default-query-univalence', [
			"violationUnivalence" => $result["violation"],
			"licenseUnivalence" => $result["license"],
			"carUnivalence" => $result["car"]
		]);
	}

	// 修改默认服务价格
	public function changeDefaultServiceUnivalence()
	{
		$companyExpressUnivalence = DB::table('fee_types')->select('number')->where("category", "20")->where("item", "1")->first();
	    $personExpressUnivalence = DB::table('fee_types')->select('number')->where("category", "20")->where("item", "0")->first();
	    $companyAgencyUnivalence = DB::table('fee_types')->select('number')->where("category", "30")->where("item", "1")->first();
	    $personAgencyUnivalence = DB::table('fee_types')->select('number')->where("category", "30")->where("item", "0")->first();

		return View::make('pages.admin.business-center.change-default-service-univalence', [
			"companyExpressUnivalence" => $companyExpressUnivalence->number,
			"personExpressUnivalence" => $personExpressUnivalence->number,
			"companyAgencyUnivalence" => $companyAgencyUnivalence->number,
			"personAgencyUnivalence" => $personAgencyUnivalence->number
		]);
	}

	public function refundIndentInfo()
	{
		$indentId = Input::get("indent_id");

		$indent = AgencyOrder::where("order_id", "=", $indentId)->first();

		if(count($indent) == 0)
			return View::make('errors.refund-indent-missing');

		return View::make('pages.admin.business-center.refund-indent-info', [
			"indent" => $indent
		]);
	}

	public function refundStatus()
	{
		return View::make('pages.admin.business-center.refund-status');
	}

	public function refundApplicationList()
	{
		return View::make('pages.admin.business-center.refund-application-list');
	}

	public function expressTicketInfo()
	{
		return View::make('pages.admin.business-center.express-ticket-info');
	}

	public function approveRefundApplication()
	{
		return View::make('pages.admin.business-center.approve-refund-application');
	}
}






