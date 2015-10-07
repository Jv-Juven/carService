<?php

class AdminController extends BaseController{

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