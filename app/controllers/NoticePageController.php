<?php

class NoticePageController extends BaseController{
	//全部通知消息
	public function all()
	{
		$notices = Notice::with([
								'notice_user_id'=>function($query)
								{
									$query->where('user_id',Sentry::getUser()->user_id);
								}
								])
							->get();

		$info = array();
		foreach( $notices as $notice)
		{
			$data = array();
			$data['notice_id'] = $notice->notice_id;
			$data['title']	= $notice->title;
			if( isset($notice->notice_user_id))
			{
				$data['read_type'] = 1;
			}else{
				$data['read_type'] = 0;
			}
			array_push($info, $data);
		}

		return $info;	
		// return View::make('')->with(array('notices'=>$info));
	}

	//未读消息
	public function unread()
	{
		$notices = Notice::with('notice_user_id')->get();
		$info = array();
		foreach( $notices as $notice)
		{
			$data = array();
			if( !isset($notice->notice_user_id))
			{
				$data['notice_id'] = $notice->notice_id;
				$data['title']	= $notice->title;
				array_push($info, $data);
			}
		}

		return $info;	
		// return View::make('');
	}

	//已读消息
	public function read()
	{
		$notices = Notice::with('notice_user_id')->get();
		$info = array();
		foreach( $notices as $notice)
		{
			$data = array();
			if( isset($notice->notice_user_id))
			{
				$data['notice_id'] = $notice->notice_id;
				$data['title']	= $notice->title;
				array_push($info, $data);
			}
		}

		return $info;	
		// return View::make('');
	}
}