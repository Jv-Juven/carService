	<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth.admin', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('/admin/login');
		}
	}
});

Route::filter('auth.user.isIn',function()
{
	Session_start();
	// $user = User::where('user_type',1)->first();
	// $user = User::find('yhxx5617c959d6ee4142025859');//服务器
	// $user = User::find('yhxx561b9668de14c743766231');//本地
	// Sentry::login($user,false);	
	// Sentry::logout();
	if(!Sentry::check())
	{
		if (Request::ajax())
		{
			return Response::json(array('errCode' => 10,'message' => '请登陆！'));
		}
		else{
			Session::put( 'url_before_login', Request::url() );
			return Redirect::guest('/');
		}
	}
	// $status = Sentry::getUser()->status;
	// if( $status != 22 )
	// {
	// 	switch ( $status ) {
	// 		case 10:
	// 			return View::make('pages.register-b.email-active');//邮箱激活页面
	// 		case 11:
	// 			return View::make('pages.register-b.reg-info');//信息登记
	// 		case 20:
	// 			return View::make('pages.register-b.success');//信息审核中
	// 		case 21:
	// 			return View::make('pages.register-b.success');//等待用户校验激活
	// 		case 30:
	// 			return View::make('errors.lock');//帐号锁定页面
	// 	}
	// }
});

Route::filter('home.auth', function()
{
	if ( Sentry::check() )
	{	
		$status = Sentry::getUser()->status;
		if( $status != 22 )
		{
			switch ( $status ) {
				case 10:
					return View::make('pages.register-b.email-active');//邮箱激活页面
				case 11:
					return View::make('pages.register-b.reg-info');//信息登记
				case 20:
					return View::make('pages.register-b.success');//信息审核中
				case 21:
					return View::make('pages.register-b.success');//等待用户校验激活
				case 30:
					return View::make('errors.lock');//帐号锁定页面
			}
		}
		return Redirect::to('serve-center/search/pages/violation');
	}
});


Route::filter('auth.isRegister', function()
{
	Session_start();
	if (Auth::check())
	{
		if (Request::ajax())
		{
			return Response::json(array('errCode' => 10,'message' => '请登陆！'));
		}
		else
		{
			return Redirect::guest('/');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
