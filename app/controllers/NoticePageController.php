<?php

class NoticePageController extends BaseController{
	//全部通知消息
	public function all()
	{
		$notices = Notice::with('users_read_id')->get();

		$info = array();
		foreach( $notices as $notice)
		{
			$data = array();
			$data['notice_id'] = $notice->notice_id;
			$data['title']	= $notice->title;
			echo ($notice->users_read_id);
			if(isset($notice->users_read_id))
			{
				$data['read_type'] = 1;
			}else{
				$data['read_type'] = 0;
			}
			array_push($info, $data);
		}

		return $info;	
		// return View::make('');
	}

	//未读消息
	public function unread()
	{

	}

	//已读消息
	public function read()
	{

	}
}