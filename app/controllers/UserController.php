<?php
use Gregwar\Captcha\CaptchaBuilder;

class UserController extends BaseController{

	//生成验证码(congcong网)
	public function captcha()
	{	
		session_start();
		$builder = new CaptchaBuilder;
		$builder->build();
		$_SESSION['phrase'] = $builder->getPhrase();
		header("Cache-Control: no-cache, must-revalidate");
		header('Content-Type: image/jpeg');
		$builder->output();
		exit;
	}

	//C端用户注册
	public function cRegister()
	{

	}

	//B端用户注册
	public function bRegister()
	{

	}

}
