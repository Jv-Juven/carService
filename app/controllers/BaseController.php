<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	//获取token
	public static function token()
	{	
		if( Cache::get('app_token') != null )
			return Cache::get('app_token');
		
		//获取token的链接
		$url = Config::get('domain.server').'/token';
		$business_user = BusinessUser::find(Sentry::getUser()->user_id);
		//获取token的参数
		$appkey = $business_user->app_key;
		$secretkey = $business_user->app_secret;
		$parm = 'appkey='.urlencode( $appkey ).'&secretkey='.urlencode( $secretkey );
		// dd($secretkey);
		$token = json_decode( CurlController::post($url,$parm),true );

		if($token['errCode'] != 0 )
		{	
			Log::info($token);
			return Response::json(array('errCode'=>1,'message'=>'token获取失败'));
		}
		Cache::put('app_token',$token['token'],100);
		
		return $token['token'];
	}

	public static function errMessage($number)
	{
		switch ( $number ) {
			case 1:
				return array('errCode'=>1, 'message'=>'非法的appkey');
			case 2:
				return array('errCode'=>2, 'message'=>'非法的secretkey');
			case 3:
				return array('errCode'=>3, 'message'=>'非法的token');
			case 4:
				return array('errCode'=>4, 'message'=>'token不存在或已过期');
			case 6:
				return array('errCode'=>6, 'message'=>'数据库错误');
			case 7:
				return array('errCode'=>7, 'message'=>'远程接口错误');
			case 8:
				return array('errCode'=>8, 'message'=>'与该用户对应的app信息不存在');
			case 9:
				return array('errCode'=>9, 'message'=>'非法的参数错误');
			case 10:
				return array('errCode'=>10, 'message'=>'账户余额不足');
			default:
				return array('errCode'=>20, 'message'=>'传入参数不正确');
		}
	}

	//根据状态码重定向
	public function redirect()
	{
		if(Sentry::getUser()->status != 22)
		{
			switch (Sentry::getUser()->status) {
				case 10:
					return Redirect::to('pages.register-b.email-active');
				case 11:
					return View::make('pages.register-b.reg-info');
				case 20:
					return Redirect::to('user/money_remark_code');
				case 21:
					return View::make('等待用户校验激活');
				default:
					return View::make('账号锁定');
			}
		}
	}
}
