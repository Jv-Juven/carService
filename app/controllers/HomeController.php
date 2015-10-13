<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home(){

		$notices = Notice::select( 'id', 'title' )->orderBy( 'created_at' )->limit( 2 )->get();

		if ( Sentry::check() ){
			$message_url = '/message-center/message/all';
		}
		else{
			$message_url = '/message-center/message/home';
		}

		return View::make( 'pages.login', [ 'notices' => $notices, 'message_url' => $message_url ] );
	}
}
