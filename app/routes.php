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

Route::get('/', function()
{
	return View::make('layouts.submaster');
});

Route::group(array('prefix'=>'user'), function(){
	//获取验证码
	Route::get('captcha', 'UserController@captcha');
	//B端用户邮箱注册页
	Route::get('b_register','UserPageController@bSiteRegisterPage');
	//B端用户注册
	Route::post('b_register','UserController@bSiteRegister');
	//B端用户邮箱注册验证通过后跳转到邮箱激活页面
	Route::get('b_active','UserPageController@emailActivePage');
	//发到B端用户邮箱后，点击链接验证，通过后去到信息登记页
	Route::get('b_site_active','UserPageController@isEmailActive');
	//C端用户注册
	Route::post('c_register','UserController@cSiteRegister');
});