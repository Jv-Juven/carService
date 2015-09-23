<?php

class NoticePageController extends BaseController{

	public function notice()
	{
		$notices = Notice::all()->with('users_read_id');

		$info = array();

		
	}
}