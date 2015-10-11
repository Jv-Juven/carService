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

	//传图片数据地址－后台逻辑用
	public function downloadToken( $addr )
	{
		$accessKey = Config::get('qiniu.qiniu.accessKey');
		$secretKey = Config::get('qiniu.qiniu.secretKey');
		$auth = new Auth($accessKey, $secretKey);
		$baseUrl = Config::get('qiniu.domain').$addr;

		return  $auth->privateDownloadUrl($baseUrl);
	}

	//前端用
	public function downloadTokenOfFront( )
	{	
		$addr = Input::get('addr');
		if( !isset($addr ))
			return Response::json(array('errCode'=> 21, 'message'=>'请传入图片名字' ));
		
		$accessKey = Config::get('qiniu.qiniu.accessKey');
		$secretKey = Config::get('qiniu.qiniu.secretKey');
		$auth = new Auth($accessKey, $secretKey);
		$baseUrl = Config::get('qiniu.domain').$addr;
		
		return Response::json(array('errCode'=> 21, 
									'message'=> 'ok',
									'downloadtoken'=> $auth->privateDownloadUrl($baseUrl)
									));
	}

}
