<?php

class AdminController extends BaseController{
	
	// 设置转账备注码
	public function setRemarkCode()
	{
		$userId = Input::get("userId");
		$remarkCode = Input::get("remarkCode");

		if(count($remarkCode) != 6) 
			return Response::json(array('errCode' => 1, 'errMsg' => "备注码必须为六位"));

		$result = User::where("user_id", "=", $userId)->update(["remark_code" => $remarkCode]);
	
		if(!$result) 
			return Response::json(array('errCode' => 1, 'errMsg' => "该用户不存在"));
			
		return Response::json(array('errCode' => 0));
	}

	// 修改用户状态
	public function changeUserStatus()
	{
		
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
			    DB::table('fee_types')->where("category", "=", "20")->where("item", "=", "2")->update(["number" => $companyExpressUnivalence]);
			    DB::table('fee_types')->where("category", "=", "20")->where("item", "=", "1")->update(["number" => $personExpressUnivalence]);
			    DB::table('fee_types')->where("category", "=", "30")->where("item", "=", "2")->update(["number" => $companyAgencyUnivalence]);
			    DB::table('fee_types')->where("category", "=", "30")->where("item", "=", "1")->update(["number" => $personAgencyUnivalence]);
			});
		} catch(Exception $e) {
			return Response::json(array('errCode' => 1, "errMsg" => "修改失败"));
		}

		return Response::json(array('errCode' => 0));
	}

	// 修改默认查询价格
	public function changeDefaultQueryUnivalence()
	{
		
	}

	// 修改特定用户的服务价格
	public function changeServiceUnivalence()
	{
		$userId = Input::get("userId");
	}

	// 修改特定用户的查询价格
	public function changeQueryUnivalence()
	{
		
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