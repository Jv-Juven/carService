<?php

class ServerCenterPageController extends BaseController{

	//违章查询
	public function violation()
	{
		return View::make('pages.serve-center.data.violation');
	}

	//驾驶证查询
	public function drive()
	{
		return View::make('pages.serve-center.data.drive');
	}

	//车辆查询
	public function cars()
	{
		return View::make('pages.serve-center.data.cars');
	}

	//违章办理
	public function vio()
	{
		return View::make('pages.serve-center.business.vio');
	}

	//违章代办
	public function indentAgency()
	{
		return View::make('<pages class="serve"></pages>-center.indent.indent-agency');
	}

}