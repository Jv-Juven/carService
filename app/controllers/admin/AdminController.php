<?php

use Illuminate\Hashing\BcryptHasher;

class AdminController extends BaseController {

	public function publishNotice()
	{
		$title = Input::get("title");
		$content = Input::get("content");

		if(!$title || !$content) 
			return Response::json(array("errCode" => 1, "errMsg" => "[参数错误]请填写要发布公告的标题和内容"));

		$notice = new Notice;
		$notice->title = $title;
		$notice->content = $content;

		if(!$notice->save()) 
			return Response::json(array("errCode" => 1, "errMsg" => "[数据库错误]发布失败"));
			
		return Response::json(array("errCode" => 0));
	}

	public function getCount()
	{
		$startDate = Input::get("startDate");
		$endDate = Input::get("endDate");
		$uid = Input::get("uid");

		try {
			$data = BusinessController::count($uid, $startDate, $endDate);
		} catch (Exception $e) {
			return Response::json(array("errCode" => 1, "errMsg" => "[服务器错误]获取访问接口统计数据失败"));
		}

		return Response::json(array("errCode" => 0, "data" => $data));
	}

	public function changeRefundStatus()
	{
		$indentId = Input::get("indentId");
		$status = Input::get("status");

		// 退款请求审批通过，订单处理状态变为<已关闭>，退款申请的审核状态变为<审核通过退款中>，订单交易状态变为<已退款>
		if($status == "1")
		{
			$result = DB::table('refund_records')
						->where("refund_records.order_id", "=", $indentId)
						->where("agency_orders.order_id", "=", $indentId)
						->join('agency_orders', 'agency_orders.order_id', '=', 'refund_records.order_id')
						->update(["refund_records.status" => $status, "agency_orders.trade_status" => "3", "process_status" => "4"]);

			$resp = BeeCloudController::refund( $indentId );

			if($resp["errCode"] != 0)
				return Response::json(array("errCode" => 1, "errMsg" => $resp["message"]));

			if($result == 0)
				return Response::json(array("errCode" => 1, "errMsg" => "订单未找到，请检查订单号是否正确"));

			return Response::json(array("errCode" => 0));
		}
		// 退款请求审批未通过，订单处理状态不变，订单交易状态还原为<已付款>，退款申请的审核状态变为<审核不通过>
		if($status == "3")
		{
			$result = DB::table('refund_records')
						->where("refund_records.order_id", "=", $indentId)
						->where("agency_orders.order_id", "=", $indentId)
						->join('agency_orders', 'agency_orders.order_id', '=', 'refund_records.order_id')
						->update(["refund_records.status" => $status, "agency_orders.trade_status" => "1"]);
			
			if($result == 0)
				return Response::json(array("errCode" => 1, "errMsg" => "订单未找到，请检查订单号是否正确"));
			
			return Response::json(array("errCode" => 0));
		}

		return Response::json(array("errCode" => 1, "errMsg" => "状态参数错误"));
	}

	public function changeIndentStatus()
	{
		$indentId = Input::get("indentId");
		$status = Input::get("status");

		if($status != "2" && $status != "3")
			return Response::json(array("errCode" => 1, "errMsg" => "[参数错误]非法的状态值"));

		$result = AgencyOrder::where("order_id", "=", $indentId)->update(["process_status" => $status]);
		
		if($result == 0)
			return Response::json(array("errCode" => 1, "errMsg" => "订单未找到，请检查订单号是否正确"));

		return Response::json(array("errCode" => 0));
	}

	public function getIndents()
	{
		$type = Input::get("type");

		$indents = [];
		if($type == "id")
		{
			$indentId = Input::get("indentId");

			$indents = AgencyOrder::where("order_id", "=", $indentId)->with("traffic_violation_info")->get();
		}
		else
		{
			$licensePlate = Input::get("licensePlate");
			$startDate = Input::get("startDate");
			$endDate = Input::get("endDate");
			$status = Input::get("status", "all");

			$query = AgencyOrder::where("car_plate_no", "=", $licensePlate)->where("created_at", ">", $startDate)->where("created_at", "<", $endDate);
			
			if($status != "all") 
				$query = $query->where("process_status", "=", $status);

			$indents = $query->with("traffic_violation_info")->get();
		}
		
		return Response::json(array("errCode" => 0, "indents" => $indents));
	}

	public function login()
	{
		$username = Input::get("username");
		$password = Input::get("password");

		if(Auth::attempt(array('username' => $username, 'password' => $password)))
		{
		    return Response::json(array("errCode" => 0));
		} 
		else
		{
		    return Response::json(array("errCode" => 1, "errMsg" => "[登陆失败]用户名或密码错误"));
		}
	}

	public function logout()
	{
		Auth::logout();

		return Response::json(array("errCode" => 0));
	}

	public function register()
	{
		$username = Input::get("username");
		$password = Input::get("password");

		$hasher = new BcryptHasher();

		$admin = new Admin();//实例化User对象
	    $admin->username = $username;
	    $admin->password = $hasher->make($password);
	    $admin->save();
		
		return Response::json(array("errCode" => 0));
	}

	public function changePassword()
	{
		$adminId = Input::get("adminId");
		$username = Input::get("username");
		$oldPassword = Input::get("oldPassword");
		$newPassword = Input::get("newPassword");
		$newPasswordConfirm = Input::get("newPasswordConfirm");

		$hasher = new BcryptHasher();

		if(Auth::attempt(array('username' => $username, 'password' => $oldPassword)))
		{
			$result = Admin::where("admin_id", "=", $adminId)->update(["password" => $hasher->make($newPassword)]);
			
			if($result == 0)
			{
				return Response::json(array('errCode' => 1, 'errMsg' => "[修改失败]数据库错误"));
			}
		} 
		else
		{
			return Response::json(array('errCode' => 1, 'errMsg' => "[修改失败]原密码错误"));
		}


		return Response::json(array('errCode' => 0));
	}
	
	public function feedback()
	{
		$feedbackId = Input::get("feedbackId");

		$result = Feedback::where("feedback_id", "=", $feedbackId)->update(["status" => true]);
	
		if(!$result)
			return Response::json(array('errCode' => 1, 'errMsg' => "[数据库错误]找不到该条反馈信息"));

		return Response::json(array('errCode' => 0));
	}

	// 设置转账备注码
	public function setRemarkCode()
	{
		$userId = Input::get("userId");
		$remarkCode = Input::get("remarkCode");

		if(strlen($remarkCode) != 6) 
			return Response::json(array('errCode' => 1, 'errMsg' => "备注码必须为六位"));

		if(!is_numeric($remarkCode))
			return Response::json(array('errCode' => 1, 'errMsg' => "备注码必须为数字"));

		$result = User::where("user_id", "=", $userId)->update(["remark_code" => $remarkCode, "status" => "21"]);
	
		if(!$result) 
			return Response::json(array('errCode' => 1, 'errMsg' => "该用户不存在"));
			
		return Response::json(array('errCode' => 0));
	}

	// 修改用户状态
	public function changeUserStatus()
	{
		$userId = Input::get("userId");
		$status = Input::get("status");

		try {
			$result = User::where("user_id", "=", $userId)->update(["status" => $status]);

			if($result == 0)
				return Response::json(array('errCode' => 1, "errMsg" => "[数据库错误]该用户信息不存在，修改失败"));
				
		} catch (Exception $e) {
			return Response::json(array('errCode' => 1, "errMsg" => "[数据库错误]修改失败"));
		}
		
		return Response::json(array('errCode' => 0));
	}

	// 修改默认服务价格
	public function changeDefaultServiceUnivalence()
	{
		$companyExpressUnivalence = Input::get("companyExpressUnivalence");
		$personExpressUnivalence = Input::get("personExpressUnivalence");
		$companyAgencyUnivalence = Input::get("companyAgencyUnivalence");
		$personAgencyUnivalence = Input::get("personAgencyUnivalence");

		try {
			DB::transaction(function() use($companyExpressUnivalence, $personExpressUnivalence, $companyAgencyUnivalence, $personAgencyUnivalence)
			{
			    DB::table('fee_types')->where("category", "=", "20")->where("item", "=", "1")->update(["number" => $companyExpressUnivalence]);
			    DB::table('fee_types')->where("category", "=", "20")->where("item", "=", "0")->update(["number" => $personExpressUnivalence]);
			    DB::table('fee_types')->where("category", "=", "30")->where("item", "=", "1")->update(["number" => $companyAgencyUnivalence]);
			    DB::table('fee_types')->where("category", "=", "30")->where("item", "=", "0")->update(["number" => $personAgencyUnivalence]);
			});
		} catch(Exception $e) {
			return Response::json(array('errCode' => 1, "errMsg" => "修改失败"));
		}

		return Response::json(array('errCode' => 0));
	}

	// 修改默认查询价格
	public function changeDefaultQueryUnivalence()
	{
		$violationUnivalence = Input::get("violationUnivalence");
		$licenseUnivalence = Input::get("licenseUnivalence");
		$carUnivalence = Input::get("carUnivalence");

		$query = [
			"violation" => $violationUnivalence,
			"license" => $licenseUnivalence,
			"car" => $carUnivalence
		];

		try 
		{
			$result = BusinessController::modify_default_univalence($query);
		} 
		catch(Exception $e) 
		{
			return Response::json(array('errCode' => 1, "errMsg" => "[数据库错误]修改失败"));
		}

		return Response::json(array('errCode' => 0));
	}

	// 修改特定用户的服务价格
	public function changeServiceUnivalence()
	{
		$userId = Input::get("userId");
			
		try {
			DB::beginTransaction();
			if(Input::has("expressUnivalence")) 
			{
				$expressUnivalence = Input::get("expressUnivalence");
				$feetype = DB::table("fee_types")->select("id")->where("category", "20")->where("item", "1")->first();

				$query = DB::table("user_fee")->where("user_id", $userId)->where("fee_type_id", $feetype->id);

				if(count($query->first()) == 0) 
				{
					$userFee = new UserFee();
					$userFee->user_id = $userId;
					$userFee->fee_type_id = $feetype->id;
					$userFee->fee_no = $expressUnivalence;
					$userFee->save();
				}
				else
				{
					$query->update(["fee_no" => $expressUnivalence]);
				}

			}

			if(Input::has("agencyUnivalence"))
			{
				$agencyUnivalence = Input::get("agencyUnivalence");
				$feetype = DB::table("fee_types")->select("id")->where("category", "30")->where("item", "1")->first();
			
				$query = DB::table("user_fee")->where("user_id", $userId)->where("fee_type_id", $feetype->id);

				if(count($query->first()) == 0) 
				{
					$userFee = new UserFee();
					$userFee->user_id = $userId;
					$userFee->fee_type_id = $feetype->id;
					$userFee->fee_no = $agencyUnivalence;
					$userFee->save();
				}
				else
				{
					$query->update(["fee_no" => $agencyUnivalence]);
				}
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			return Response::json(array('errCode' => 1, "errMsg" => "[数据库错误]修改失败"));
		}

		return Response::json(array('errCode' => 0));
	}

	// 修改特定用户的查询价格
	public function changeQueryUnivalence()
	{
		$userId = Input::get("userId");
		$params = Input::get("params");
		try 
		{
			$result = BusinessController::modify_business_user_univalence($userId, $params);
		} 
		catch (Exception $e) 
		{
			return Response::json(array('errCode' => 1, "errMsg" => "[数据库错误]修改失败"));
		}

		return Response::json(array('errCode' => 0));
	}

	// 通过企业名称或营业执照号查询用户信息
	public function searchUser()
	{
		$type = Input::get("type");
		$companyName = Input::get("companyName", "");
		$licenseCode = Input::get("licenseCode", "");

		if($type == "companyName")
			$users = BusinessUser::where("business_name", "like", "%" . $companyName . "%")->with("user")->get();
		if($type == "licenseCode")
			$users = BusinessUser::where("business_licence_no", "like", "%" . $licenseCode . "%")->with("user")->get();

		if(count($users) == 0)
			return Response::json(array('errCode' => 0, 'users' => array()));

		return Response::json(array('errCode' => 0, 'users' => $users));
	}
}