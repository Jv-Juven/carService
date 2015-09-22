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

Route::group(array('prefix'='user'), function(){
	//获取验证码
	Route::get('captcha', 'UserController@captcha');
	//B端用户注册
	Route::post('b_register','UserController@bRegister');
	//C端用户注册
	Route::post('c_register','UserController@cRegister');
});