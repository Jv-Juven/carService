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

	// 获取企业用户访问次数
	public function userQueryCount()
	{
		$appkey = Input::get("appkey");
		$startDate = Input::get("start_date");
		$endDate = Input::get("end_date");

		return View::make('pages.admin.business-center.user-query-count', [
			"appkey" => $appkey
		]);
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
			$indents = AgencyOrder::where("process_status", "=", "0")->orderBy("updated_at", "desc")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "treated")
			$indents = AgencyOrder::where("process_status", "=", "1")->orderBy("updated_at", "desc")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "treating")
			$indents = AgencyOrder::where("process_status", "=", "2")->orderBy("updated_at", "desc")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "finished")
			$indents = AgencyOrder::where("process_status", "=", "3")->orderBy("updated_at", "desc")->with("traffic_violation_info")->paginate($perPage);
		else if($type == "closed")
			$indents = AgencyOrder::where("process_status", "=", "4")->orderBy("updated_at", "desc")->with("traffic_violation_info")->paginate($perPage);
		else
			$indents = AgencyOrder::orderBy("created_at", "desc")->with("traffic_violation_info")->paginate($perPage);

		$indents->addQuery( 'type', $type );

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

		$indent = AgencyOrder::where("order_id", "=", $indentId)->with("traffic_violation_info")->first();

		$indent->car_type = Config::get("carType." . $indent->car_type_no);

		if(count($indent) == 0)
			return View::make('errors.refund-indent-missing');

		return View::make('pages.admin.business-center.refund-indent-info', [
			"indent" => $indent
		]);
	}

	public function refundStatus()
	{
		$indentId = Input::get("indent_id");

		$result = DB::table('agency_orders')
						->where("agency_orders.order_id", "=", $indentId)
						->where("refund_records.order_id", "=", $indentId)
						->join('refund_records', 'agency_orders.order_id', '=', 'refund_records.order_id')
						->first();

		if(!isset($result))
			return View::make('errors.page-error', ["errMsg" => "订单未找到，请检查订单号是否正确"]);

		$resp = BeeCloudController::getRefundStatus($result->refund_id);

		if($resp["errCode"] == 0) {
			if($resp["result"]) {
				RefundRecord::where("order_id", "=", $indentId)->update(["status" => "2"]);
				AgencyOrder::where("order_id", "=", $indentId)->update(["process_status" => "4"]);
			} else {
				RefundRecord::where("order_id", "=", $indentId)->update(["status" => "4"]);
				AgencyOrder::where("order_id", "=", $indentId)->update(["process_status" => "4", "trade_status" => "3"]);
			}

			return View::make('pages.admin.business-center.refund-status', [ 
				"indent" => $result,
				"result" => $resp["result"]
			]);
		} else {
			return View::make('errors.page-error', ["errMsg" => $resp["message"]]);
		}
	}

	public function refundApplicationList()
	{
		$type = Input::get("type", "all");
		$perPage = 15;

		if($type == "approving") {
			$refundIndents = RefundRecord::where("status", "=", "0")->orderBy("updated_at", "desc")->with(["order", "user_info"])->paginate($perPage);
		} else if($type == "pass") {
			$refundIndents = RefundRecord::where("status", "=", "1")->orWhere("status", "=", "2")->orWhere("status", "=", "4")->orderBy("updated_at", "desc")->with(["order", "user_info"])->paginate($perPage);
		} else if($type == "unpass") {
			$refundIndents = RefundRecord::where("status", "=", "3")->orderBy("updated_at", "desc")->with(["order", "user_info"])->paginate($perPage);
		} else {
			$refundIndents = RefundRecord::orderBy("created_at", "desc")->with(["order", "user_info"])->paginate($perPage);
		}

		return View::make('pages.admin.business-center.refund-application-list', [
			"refundIndents" => $refundIndents,
			"count" => $refundIndents->count(),
			"totalCount" => $refundIndents->getTotal()
		]);
	}

	public function expressTicketInfo()
	{
		$indentId = Input::get("indent_id");

		$indent = AgencyOrder::where("order_id", "=", $indentId)->first();

		if(!isset($indent))
			return View::make('errors.page-error', ["errMsg" => "订单未找到，请检查订单号是否正确"]);

		return View::make('pages.admin.business-center.express-ticket-info', ["indent" => $indent]);
	}

	public function approveRefundApplication()
	{
		$indentId = Input::get("indent_id");

		$indent = AgencyOrder::where("order_id", "=", $indentId)->with("refund_record", "traffic_violation_info")->first();

		if(!isset($indent))
			return View::make('errors.page-error', ["errMsg" => "订单未找到，请检查订单号是否正确"]);

		return View::make('pages.admin.business-center.approve-refund-application', [
			"indent" => $indent
		]);
	}
}






