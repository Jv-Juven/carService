<?php

class AdminController extends BaseController{
	
	// 设置转账备注码
	public function setRemarkCode()
	{
		$userId = Input::get("userId");
		$remarkCode = Input::get("remarkCode");

		if(strlen($remarkCode) != 6) 
			return Response::json(array('errCode' => 1, 'errMsg' => "备注码必须为六位"));

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