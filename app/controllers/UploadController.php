<?php
use Qiniu\Auth;

class UploadController extends \BaseController {
	
	public function getUpToken()
	{
		$accessKey = Config::get('qiniu.accessKey');
		$secretKey = Config::get('qiniu.secretKey');
		$auth = new Auth($accessKey, $secretKey);
		$bucket = 'cheshang';
		$upToken = $auth->uploadToken($bucket);
		return Response::json(array("uptoken" => $upToken));
	}
}
