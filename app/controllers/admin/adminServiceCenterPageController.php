<?php

class adminServiceCenterPageController extends BaseController{

	public function all()
	{
		return View::make('pages.admin.service-center.all');
	}

	public function treated()
	{
		return View::make('pages.admin.service-center.treated');
	}

	public function untreated()
	{
		return View::make('pages.admin.service-center.untreated');
	}
}