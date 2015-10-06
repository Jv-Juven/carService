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

Route::get('/',function(){
	return View::make('pages.login');
});

Route::group(array('prefix'=>'user'), function(){
	//B端用户邮箱注册页
	Route::get('b_register','UserPageController@bSiteRegisterPage');
	//B端用户注册－发到B端用户邮箱后，点击链接验证，通过后去到信息登记页
	Route::get('b_site_active','UserPageController@isEmailActive');
	//获取验证码
	Route::get('captcha', 'UserController@captcha');
	//B端用户注册-密码页
	Route::post('b_register','UserController@bSiteRegister');
	//B,C端登录
	Route::post('login','UserController@login');
	//C端用户注册-获取手机验证码
	Route::get('phone_code','UserController@getPhoneCode');
	//C端用户注册－密码页
	Route::post('c_register','UserController@cSiteRegister');
	
	Route::group(array('before'=>'auth.user.isIn'),function(){
		//B端用户注册－填写完注册信息后跳转到邮箱激活页面
		Route::get('email_active','UserPageController@emailActivePage');
		//B端用户注册-信息登记
		Route::post('info_register', 'UserController@informationRegister');
		//B端用户注册-意外退出后发送验证信息再次发送信息到邮箱
		Route::get('send_token_to_email','UserController@sendTokenToEmail');
		//B端用户注册－运营人员手机验证码
		Route::get('operational_phone_code','UserController@operationalPhoneCode');
		//B端用户打款备注码
		Route::post('money_remark_code','UserController@moneyRemarkCode');
		//显示企业信息
		Route::post('display_company_info','UserController@displayCompanyRegisterInfo');

		//B端用户邮箱注册验证通过后跳转到邮箱激活页面
		Route::get('b_active','UserPageController@emailActivePage');
		//打款验证码静态页面
		Route::get('remark_code','UserPageController@remarkCode');
		//c端用户修改密码－发送验证码到手机
		Route::post('send_code_to_phone','UserController@sendResetCodeToPhone');
		//c端用户修改密码－重置密码
		Route::post('reset_csite_pwd','UserController@resetCustomerSitePassword');
		//b端用户修改密码－发送验证码到邮箱
		Route::post('send_code_to_email','UserController@sendResetCodeToEmail');
		//b端用户修改密码－重置密码
		Route::post('reset_bsite_pwd', 'UserController@resetBusinessSitePassword');
		//获取appkey和secretkey
		Route::get('app', 'UserController@app');
		//获取token
		Route::post('token', 'UserController@token');
		//反馈
		Route::post('feedback','FeedbackController@feedback');
	});
});

//账户中心
Route::group(array('prefix'=>'account-center'),function(){
	//帐号信息
	Route::get('account-info','AccountPageController@accountInfo');
	//开发者中心
	Route::get('developer-info','AccountPageController@developerInfo');
});

//服务中心
Route::group(array('prefix'=>'serve-center'),function(){
	//违章查询
	Route::get('violation','ServerCenterPageController@violation');
	//驾驶证查询
	Route::get('drive','ServerCenterPageController@drive');
	//车辆查询
	Route::get('cars','ServerCenterPageController@cars');
	//违章办理
	Route::get('vio','ServerCenterPageController@vio');
	//违章代办
	Route::get('indent-agency','ServerCenterPageController@indentAgency');
});

//业务逻辑
Route::group(array('prefix'=>'business','before'=>'auth.user.isIn'),function(){
	//校验充值的token接口
	Route::get('auth','BusinessController@authToken');
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
	Route::post('submit_order', 'BusinessController@submitOrder');
	//查看违章代办信息
	Route::get('violation_info','BusinessController@trafficViolationInfo');
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

	// 反馈模块
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
	Route::group([ 'prefix' => 'cost-manage' ], function(){

		// 概览
		Route::get( 'overview', 'CostManageController@overview');

		// 退款记录
		Route::get( 'refund-record', 'CostManageController@refund_record' );

		// 费用明细页面
		Route::get( 'cost-detail', 'CostManageController@cost_detail' );
	});

	// 充值模块
	Route::group([ 'prefix' => 'recharge' ], function(){

		// 充值页面
		Route::get( '/', 'RechargeController@index' );
	});
});
	
// Route::get('tiger',function(){
	
// });

Route::get('test',function(){
	Sentry::login(User::find('yhxx560214c236150446972440'), false);
	$user = User::find('yhxx560214c236150446972440');
	//储存数据
	// Cache::put('token',$token,5);
	Cache::put('user_id',$user->user_id,5);
	var_dump($user->user_id);
	// return uniqid('hyxx',true);
});

// 后台管理
Route::group(array('prefix' => 'admin'), function() {

	// 客服中心
	Route::group(array('prefix' => 'service-center'), function() {
		// 全部
		Route::get('/all', 'adminServiceCenterPageController@all');
		// 已处理
		Route::get('/treated', 'adminServiceCenterPageController@treated');
		// 未处理
		Route::get('/untreated', 'adminServiceCenterPageController@untreated');
	});

	// 操作中心
	Route::group(array('prefix' => 'business-center'), function() {
		// 企业用户完整信息
		Route::get('/user-info', 'adminBusinessCenterPageController@userInfo');
		// 企业用户列表
		Route::get('/user-list', 'adminBusinessCenterPageController@userList');
		// 企业用户搜索
		Route::get('/search-user', 'adminBusinessCenterPageController@searchUser');
		// 新用户列表
		Route::get('/new-user-list', 'adminBusinessCenterPageController@newUserList');
		// 审核企业用户
		Route::get('/check-new-user', 'adminBusinessCenterPageController@checkNewUser');
		// 修改用户状态
		Route::get('/change-user-state', 'adminBusinessCenterPageController@changeUserState');
		// 修改用户查询单价
		Route::get('/change-query-univalence', 'adminBusinessCenterPageController@changeQueryUnivalence');
		// 修改用户服务单价
		Route::get('/change-service-univalence', 'adminBusinessCenterPageController@changeServiceUnivalence');
		// 修改默认查询单价
		Route::get('/change-default-query-univalence', 'adminBusinessCenterPageController@changeDefaultQueryUnivalence');
		// 修改默认服务单价
		Route::get('/change-default-service-univalence', 'adminBusinessCenterPageController@changeDefaultServiceUnivalence');
	});

	// 账户设置
	Route::group(array('prefix' => 'admin-account'), function() {
		// 后台管理员账户设置
		Route::get('/', 'adminAccountPageController@index');
	});
});


















