<?php
use Qiniu\Auth;

class UploadController extends \BaseController {
	
	public function getUpToken()
	{
		$accessKey = Config::get('qiniu.qiniu.accessKey');
		$secretKey = Config::get('qiniu.qiniu.secretKey');
		$auth = new Auth($accessKey, $secretKey);
		$bucket = 'cheshang';
		$upToken = $auth->uploadToken($bucket);
		
		return Response::json(array("uptoken" => $upToken));
	}

	//传图片数据地址
	public function downloadToken( $addr )
	{
		$accessKey = Config::get('qiniu.accessKey');
		$secretKey = Config::get('qiniu.secretKey');
		$auth = new Auth($accessKey, $secretKey);
		$baseUrl = Config::get('qiniu.domain').$addr;

		return  $auth->privateDownloadUrl($baseUrl);
	}
}
