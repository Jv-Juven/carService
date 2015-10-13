<?php

class AdminServiceCenterPageController extends BaseController{

	public function publishNotice()
	{
		return View::make('pages.admin.service-center.publish-notice');
	}

	public function noticeList()
	{
		$perPage = 15;
		$notices = Notice::orderBy("created_at", "desc")->paginate($perPage);

		return View::make('pages.admin.service-center.notice-list', [
			"totalCount" => $notices->getTotal(),
			"notices" => $notices,
			"count" => $notices->count()
		]);
	}

	public function consult()
	{
		$type = Input::get("type", "all");
		$perPage = 10;

		if($type == "treated")
			$feedbacks = Feedback::where("type", "=", "1")->where("status", "=", 1)->with('user_info')->paginate($perPage);
		else if($type == "untreated")
			$feedbacks = Feedback::where("type", "=", "1")->where("status", "=", 0)->with('user_info')->paginate($perPage);
		else
			$feedbacks = Feedback::where("type", "=", "1")->with('user_info')->paginate($perPage);

		$totalCount = $feedbacks->getTotal();
		$count = $feedbacks->count();

		$feedbacks->addQuery( 'type', $type );

		return View::make('pages.admin.service-center.feedback', [
			"count" => $count,
			"feedbacks" => $feedbacks,
			"totalCount" => $totalCount
		]);
	}

	public function suggestion()
	{
		$type = Input::get("type", "all");
		$perPage = 10;

		if($type == "treated")
			$feedbacks = Feedback::where("type", "=", "2")->where("status", "=", 1)->with('user_info')->paginate($perPage);
		else if($type == "untreated")
			$feedbacks = Feedback::where("type", "=", "2")->where("status", "=", 0)->with('user_info')->paginate($perPage);
		else
			$feedbacks = Feedback::where("type", "=", "2")->with('user_info')->paginate($perPage);

		$totalCount = $feedbacks->getTotal();
		$count = $feedbacks->count();

		$feedbacks->addQuery( 'type', $type );

		return View::make('pages.admin.service-center.feedback', [
			"count" => $count,
			"feedbacks" => $feedbacks,
			"totalCount" => $totalCount
		]);
	}

	public function complain()
	{
		$type = Input::get("type", "all");
		$perPage = 10;

		if($type == "treated")
			$feedbacks = Feedback::where("type", "=", "3")->where("status", "=", 1)->with('user_info')->paginate($perPage);
		else if($type == "untreated")
			$feedbacks = Feedback::where("type", "=", "3")->where("status", "=", 0)->with('user_info')->paginate($perPage);
		else
			$feedbacks = Feedback::where("type", "=", "3")->with('user_info')->paginate($perPage);

		$totalCount = $feedbacks->getTotal();
		$count = $feedbacks->count();
		
		$feedbacks->addQuery( 'type', $type );

		return View::make('pages.admin.service-center.feedback', [
			"count" => $count,
			"feedbacks" => $feedbacks,
			"totalCount" => $totalCount
		]);
	}
}