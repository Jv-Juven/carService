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

Route::get('/', 'HomeController@home');

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
	//b端用户－忘记密码－需要邮箱
	Route::post('send-resetcode-to-email','UserController@sendResetCodeToEmail');
	//C端用户－忘记密码－获取手机验证码
	Route::post('send-resetcode-to-cell','UserController@sendResetCodeToCell');
	//C端用户注册-获取手机验证码
	Route::post('phone_code','UserController@getPhoneCode');
	//C端用户注册－密码页
	Route::post('c_register','UserController@cSiteRegister');
	//b端用户忘记密码密码－重置密码
	Route::post('reset-bsite-forgetpwd','UserController@resetForgetPassword');
	//c端用户忘记密码－重置密码
	Route::post('reset-csite-forgetpwd','UserController@resetCForgetPassword');

	Route::group(array('before'=>'auth.user.isIn'),function(){
		//B端用户注册-信息登记
		Route::post('info_register', 'UserController@informationRegister');
		//B端用户注册-意外退出后发送验证信息再次发送信息到邮箱
		Route::post('send_token_to_email','UserController@sendTokenToEmail');
		//B端用户注册－填写完注册信息后跳转到邮箱激活页面
		Route::get('email_active','UserPageController@emailActivePage');
		//显示企业信息
		Route::post('display_company_info','UserController@displayCompanyRegisterInfo');
		//B端用户注册/修改运营者信息－运营人员手机验证码
		Route::get('operational_phone_code','UserController@operationalPhoneCode');
		//B端用户－修改运营者信息－保存
		Route::post('save_operator_info','UserController@saveOperatorInfo');
		//登出
		Route::post('logout','UserController@logout');
		//审核中
		Route::get('pending','UserPageController@pending');
		//信息登记静态页面
		Route::get('info_register','UserPageController@infomationRegisterPage');
		//B端用户邮箱注册验证通过后跳转到邮箱激活页面
		Route::get('b_active','UserPageController@emailActivePage');
		//c端用户修改密码－发送验证码到手机
		Route::post('send_code_to_phone','UserController@sendResetCodeToPhone');
		//c端用户修改密码－重置密码
		Route::post('reset_csite_pwd','UserController@resetCustomerSitePassword');
		//B端用户-显示企业信息/修改运营者信息/修改密码的获取验证码-不需要邮箱
		Route::post('send_code_to_email','UserController@sendCodeToEmail');
		//b端用户修改密码－重置密码
		Route::post('reset_bsite_pwd', 'UserController@resetBusinessSitePassword');
		//显示企业信息
		Route::post('dispaly-com-info','UserController@dispalyComInfo');
		//锁定页面
		Route::get('lock', 'UserPageController@lock');
		//审核不通过页面
		Route::get('no-pass','UserPageController@noPass');
		//打款验证码静态页面
		Route::get('write-code','UserPageController@writeCode');
		//填写打款验证码
		Route::post('money_remark_code','UserController@moneyRemarkCode');

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
	//账户信息－C端
	Route::get('account-info-c','AccountPageController@developerInfoOfC');
});

Route::get( 'business/auth_request_token', 'BusinessController@auth_request_token' );

// 服务中心
Route::group([ 'prefix' => 'serve-center' ], function(){

	// 数据查询模块
	Route::group([ 'prefix' => 'search' ], function(){

		// 查询相关
		Route::group([ 'prefix' => 'pages' ], function(){

			// 违章查询页面
			Route::get( 'violation', 'SearchPageController@violation' );

			Route::group([ 'before' => 'auth.user.isIn' ], function(){
				
				// 驾驶证查询页面
				Route::get( 'license', 'SearchPageController@license' );

				// 车辆查询页面
				Route::get( 'car', 'SearchPageController@car' );
			});
		});

		// 查询ajax接口
		Route::group([ 'prefix' => 'api', 'before' => 'auth.user.isIn' ], function(){

			// 违章查询
			Route::get( 'violation', 'SearchController@violation' );

			// 驾驶证查询页面
			Route::get( 'license', 'SearchController@license' );

			// 车辆查询页面
			Route::get( 'car', 'SearchController@car' );
		});
	});

	// 违章代办模块
	Route::group([ 'prefix' => 'agency', 'before' => 'auth.user.isIn' ], function(){

		// 页面路由
		Route::group([ 'prefix' => 'pages' ], function(){

			// 第一步，违章查询
			Route::get( 'search_violation', 'AgencyPageController@search_violation' );

			// 第二步，违章代办
			Route::get( 'agency', 'AgencyPageController@agency' );

			// 第三步，支付页面
			Route::get( 'pay', 'AgencyPageController@pay' );

			// 第四步，完成页面
			Route::get( 'success', 'AgencyPageController@success' );
		});

		// 办理违章ajax路由
		Route::group([ 'prefix' => 'business' ], function(){

			// 确认办理违章
			Route::post( 'confirm_violation', 'AgencyController@confirm_violation' );

			// 提交订单
			Route::post( 'submit_order', 'AgencyController@submit_order' );
		});
	});

	// 订单管理模块
	Route::group([ 'prefix' => 'order', 'before' => 'auth.user.isIn' ], function(){

		// 查询违章代办订单页面
		Route::group([ 'prefix' => 'pages' ], function(){

			Route::get( 'order_violation', 'OrderPageController@violation' );
		});

		// 操作订单接口
		Route::group([ 'prefix' => 'operation' ], function(){
			
			// 查询违章代办订单ajax接口
			Route::get( 'search', 'OrderController@search' );

			// 取消订单
			Route::post( 'cancel', 'OrderController@cancel' );
		});
	});
});

// 消息中心
Route::group([ 'prefix' => 'message-center' ], function(){

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
		Route::get( '/index', 'FeedbackController@index' );

		// 添加反馈
		Route::post( '/index', 'FeedbackController@add_feedback' );

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
		Route::get( '/index', 'RechargeController@index' );
	});
});
	
// Route::get('tiger',function(){
	
// });
/*
Route::get('test',function(){
	Sentry::login(User::find('yhxx560214c236150446972440'), false);
	$user = User::find('yhxx560214c236150446972440');
	//储存数据
	// Cache::put('token',$token,5);
	Cache::put('user_id',$user->user_id,5);
	var_dump($user->user_id);
	// return uniqid('hyxx',true);
});
*/
// 后台管理-页面
Route::group(array('prefix' => 'admin'), function() {

	Route::get('/login', 'AdminAccountPageController@login');

	// 客服中心
	Route::group(array('prefix' => 'service-center', 'before' => 'auth.admin'), function() {
		// 咨询
		Route::get('/consult', 'AdminServiceCenterPageController@consult');
		// 建议
		Route::get('/suggestion', 'AdminServiceCenterPageController@suggestion');
		// 投诉
		Route::get('/complain', 'AdminServiceCenterPageController@complain');
	});

	// 操作中心
	Route::group(array('prefix' => 'business-center', 'before' => 'auth.admin'), function() {
		// 企业用户完整信息
		Route::get('/user-info', 'AdminBusinessCenterPageController@userInfo');
		// 企业用户列表
		Route::get('/user-list', 'AdminBusinessCenterPageController@userList');
		// 企业用户搜索
		Route::get('/search-user', 'AdminBusinessCenterPageController@searchUser');
		// 查看企业用户查询次数
		Route::get('/user-query-count', 'AdminBusinessCenterPageController@userQueryCount');
		// 新用户列表
		Route::get('/new-user-list', 'AdminBusinessCenterPageController@newUserList');
		// 审核企业用户
		Route::get('/check-new-user', 'AdminBusinessCenterPageController@checkNewUser');
		// 修改用户状态
		Route::get('/change-user-status', 'AdminBusinessCenterPageController@changeUserStatus');
		// 订单搜索
		Route::get('/search-indent', 'AdminBusinessCenterPageController@searchIndent');
		// 违章代办订单列表
		Route::get('/indent-list', 'AdminBusinessCenterPageController@indentList');
		// 修改用户查询单价
		Route::get('/change-query-univalence', 'AdminBusinessCenterPageController@changeQueryUnivalence');
		// 修改用户服务单价
		Route::get('/change-service-univalence', 'AdminBusinessCenterPageController@changeServiceUnivalence');
		// 修改默认查询单价
		Route::get('/change-default-query-univalence', 'AdminBusinessCenterPageController@changeDefaultQueryUnivalence');
		// 修改默认服务单价
		Route::get('/change-default-service-univalence', 'AdminBusinessCenterPageController@changeDefaultServiceUnivalence');
		// 退款审批订单列表
		Route::get('/refund-application-list', 'AdminBusinessCenterPageController@refundApplicationList');
		// 查看申请退款订单详情
		Route::get('/refund-indent-info', 'AdminBusinessCenterPageController@refundIndentInfo');
		// 查看退款状态
		Route::get('/refund-status', 'AdminBusinessCenterPageController@refundStatus');
		// 查看办理凭证快递信息
		Route::get('/express-ticket-info', 'AdminBusinessCenterPageController@expressTicketInfo');
		// 查看申请退款订单详情
		Route::get('/approve-refund-application', 'AdminBusinessCenterPageController@approveRefundApplication');
	});

	// 账户设置
	Route::group(array('prefix' => 'account', 'before' => 'auth.admin'), function() {
		// 后台管理员账户设置
		Route::get('/change-password', 'AdminAccountPageController@changePassword');
	});
});

// 后台管理-接口
Route::group(array('prefix' => 'admin'), function() {

	// 管理员注册
	Route::post('/register', 'AdminController@register');

	// 管理员登录
	Route::post('/login', 'AdminController@login');

	Route::group(array('before' => 'auth.admin'), function() {

		// 修改退款申请审批状态
		Route::post('/change-refund-status', 'AdminController@changeRefundStatus');

		// 修改订单处理状态
		Route::post('/change-indent-status', 'AdminController@changeIndentStatus');

		// 查询违章代办订单
		Route::get('/indents', 'AdminController@getIndents');

		// 退出登录
		Route::post('/logout', 'AdminController@logout');

		// 修改管理员密码
		Route::post('/change-password', 'AdminController@changePassword');

		// 获取用户反馈
		Route::post('/feedback', 'AdminController@feedback');

		// 查询用户信息
		Route::get('/search-user', 'AdminController@searchUser');

		// 设置转账备注码
		Route::post('/set-remark-code', 'AdminController@setRemarkCode');

		// 修改用户状态
		Route::post('/change-user-status', 'AdminController@changeUserStatus');

		// 修改默认服务价格
		Route::post('/change-default-service-univalence', 'AdminController@changeDefaultServiceUnivalence');

		// 修改默认查询价格
		Route::post('/change-default-query-univalence', 'AdminController@changeDefaultQueryUnivalence');

		// 修改特定用户的服务价格
		Route::post('/change-service-univalence', 'AdminController@changeServiceUnivalence');

		// 修改特定用户的查询价格
		Route::post('/change-query-univalence', 'AdminController@changeQueryUnivalence');
	});
});

//七牛
Route::group(array('prefix'=>'qiniu','before'=>'auth.isRegister'),function(){
	//上传
	Route::get('/', 'UploadController@getUpToken');
	//下载图片
	Route::get('download-token','UploadController@downloadToken');
	//
	Route::get('front-download-token','UploadController@downloadTokenOfFront');
});



//beeclound接口
Route::group(array('prefix'=>'beeclound','before'=>'auth.user.isIn'), function(){
	//微信充值
	Route::post('recharge','BeeCloudController@recharge');
	//微信代办
	Route::post('order-agency','BeeCloudController@orderAgency');
	//用户申请退款
	Route::post('request-refund', 'OrderController@requestRefund');
	//二维码支付页面
	Route::get('qrcode','BeeCloudController@qrcode');

	//微信退款
	Route::post('refund','BeeCloudController@refund');
	//退款状态
	Route::get('refund-status','BeeCloudController@getRefundStatus');
});
	//验证
	Route::post('beeclound','BeeCloudController@authBeeCloud');













