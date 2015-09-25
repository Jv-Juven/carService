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
	//提交订单
	Route::post('violation_info','BusinessController@trafficViolationInfo');
});

// 消息中心
Route::group(array('prefix'=>'message-center'), function(){

	// 消息模块
	Route::group([ 'prefix' => 'message' ], function(){

		//主页 --- 平台公告
		Route::get( 'home', 'NoticePageController@home' );

		//获取通知详细内容
		Route::get( 'detail', 'NoticePageController@detail' );

		Route::group([ 'before' => 'auth.user.isIn' ], function(){

			//通知静态页－全部消息
			Route::get( 'all', 'NoticePageController@all' );

			//通知静态页－已读消息
			Route::get( 'read', 'NoticePageController@read' );
			
			//通知静态页－未读消息
			Route::get( 'unread', 'NoticePageController@unread') ;

			// 设置消息为已读
			Route::post( 'read_notice', 'NoticeContorller@read_notice' );
		});
	});

	// 反馈
	Route::group([ 'prefix' => 'feedback', 'before' => 'auth.user.isIn' ], function(){

		// 反馈页面
		Route::get( '/', 'FeedbackController@index' );

		// 添加反馈
		Route::post( '/', 'FeedbackController@add_feedback' );

		// 反馈成功
		Route::get( 'success', 'FeedbackController@feedback_success' );
	});
});

// 财务中心
Route::group([ 'prefix' => 'finance-center', 'before' => 'auth.user.isIn' ], function(){

	// 费用管理
	Route::group([ 'prefix' => 'cost-manange' ], function(){

		// 概览
		Route::get( 'overview', 'CostDetailController@overview');

		// 费用明细
		Route::get( 'cost-detail', 'CostDetailController@cost_detail' );

		// 退款记录
		Route::get( 'refund-record', 'CostDetailController@refund_record' );
	});

	Route::group([ 'prefix' => 'recharge' ], function(){

		// 充值页面
		Route::get( '/', 'RechargeController@index' );
	});
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