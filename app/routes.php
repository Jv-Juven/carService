<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

try{
	include 'test_routes.php';	
}catch( Exception $e ){
	
}

Route::group(array('prefix'=>'user'), function(){
	//获取验证码
	Route::get('captcha', 'UserController@captcha');
	//B端用户邮箱注册页
	Route::get('b_register','UserPageController@bSiteRegisterPage');
	//B端用户注册
	Route::post('b_register','UserController@bSiteRegister');
	//发到B端用户邮箱后，点击链接验证，通过后去到信息登记页
	Route::get('b_site_active','UserPageController@isEmailActive');
	//登录
	Route::post('login','UserController@login');
	//C端用户注册
	Route::post('c_register','UserController@cSiteRegister');
	
	Route::group(array('before'=>'auth.user.isIn'),function(){
		//B端用户邮箱注册验证通过后跳转到邮箱激活页面
		Route::get('b_active','UserPageController@emailActivePage');
		//打款验证码静态页面
		Route::get('remark_code','UserPageController@remarkCode');
		//获取appkey和secretkey
		Route::get('app', 'UserController@app');
		//获取token
		Route::post('token', 'UserController@token');
		//反馈
		Route::post('feedback','FeedbackController@feedback');
	});
});

//业务逻辑
Route::group(array('prefix'=>'business','before'=>'auth.user.isIn'),function(){
	//充值
	Route::post('recharge','BusinessController@recharge');
	//获取账户信息
	Route::get('account','BusinessController@accountInfo');
	//获取访问次数信息
	Route::get('account/count', 'BusinessController@count');
	//修改业务单价
	Route::post('account/univalence', 'BusinessController@univalence');
	//违章查询
	Route::post('api/violation','BusinessController@violation');
	//查询驾驶证扣分信息
	Route::get('api/license', 'BusinessController@license');
	//查询车辆信息
	Route::get('api/car', 'BusinessController@car');
});

Route::group(array('prefix'=>'notice','before'=> 'auth.user.isIn'), function(){
	//通知静态页－全部消息
	Route::get('/', 'NoticePageController@all');
	//通知静态页－未读消息
	Route::get('unread','NoticePageController@unread');
	//通知静态页－已读消息
	Route::get('read','NoticePageController@read');
	//获取通知详细内容
	Route::post('/','NoticeController@detail');
});


Route::get('test',function(){
	Sentry::login(User::find('yhxx560214c236150446972440'), false);
	$user = User::find('yhxx560214c236150446972440');
	//储存数据
	// Cache::put('token',$token,5);
	Cache::put('user_id',$user->user_id,5);
	var_dump($user->user_id);
	// return uniqid('hyxx',true);
});