<?php

class NoticeController extends BaseController{

	//通知的详细内容
	public function detail()
	{
		$notice_id = Input::get('notice_id');
		$notice = Notice::find($notice_id);
		if(!isset($notice))
			return View::make('errors.missing');

		return View::make('errors.missing')->with(array('notice'=>$notice));
	}
}