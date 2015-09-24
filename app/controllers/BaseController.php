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
	public function token()
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
		Cache::put('app_token',$token['token'],300);
		
		return $token['token'];
	}
}
