<?php

class AdminServiceCenterPageController extends BaseController{

	public function consult()
	{
		$type = Input::get("type", "all");
		$perPage = 10;

		if($type == "treated")
			$feedbacks = Feedback::where("type", "=", "1")->where("status", "=", 1)->paginate($perPage);
		else if($type == "untreated")
			$feedbacks = Feedback::where("type", "=", "1")->where("status", "=", 0)->paginate($perPage);
		else
			$feedbacks = Feedback::where("type", "=", "1")->paginate($perPage);

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
			$feedbacks = Feedback::where("type", "=", "2")->where("status", "=", 1)->paginate($perPage);
		else if($type == "untreated")
			$feedbacks = Feedback::where("type", "=", "2")->where("status", "=", 0)->paginate($perPage);
		else
			$feedbacks = Feedback::where("type", "=", "2")->paginate($perPage);

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
			$feedbacks = Feedback::where("type", "=", "3")->where("status", "=", 1)->paginate($perPage);
		else if($type == "untreated")
			$feedbacks = Feedback::where("type", "=", "3")->where("status", "=", 0)->paginate($perPage);
		else
			$feedbacks = Feedback::where("type", "=", "3")->paginate($perPage);

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