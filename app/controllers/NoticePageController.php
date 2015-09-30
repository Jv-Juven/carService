<?php

class NoticePageController extends BaseController{

	protected static $default_per_page = 7;

	/**
	 * 获取公告分页后结果
	 * 
	 * @return Collection
	 */
	protected function get_paginated_notice(){

		return  Notice::select( 'id', 'title', 'created_at' )
					  	->with([
							'users_read_id' => function( $query ){
								$query->select( 'notice_id' )
									  ->where( 'user_id', Sentry::getUser()->user_id );
							}
					 	])->paginate( static::$default_per_page );
	}

	// 主页公告
	public function home(){

		$paginator = $this->get_paginated_notice();

		return View::make( 'pages.message-center.message-center.home', [
			'paginator'		=> $paginator
		]);
	}
	
	//全部通知消息
	public function all(){

		// 获取notices
		$paginator = $this->get_paginated_notice();

		$notices = $paginator->getCollection();
		$notices->each(function( $notice ){

			$notice['already_read'] = isset( $notice->notice_user_id );
		});

		return View::make( 'pages.message-center.message.message', [
			'paginator'		=> $paginator
		]);
	}

	// 获取未读消息
	public function unread(){

		// 需要分页
		$paginator = Notice::select( 'notices.id', 'notices.title', 'notices.created_at' )
						 	->leftJoin( 'user_read_notice', function( $join ){

						 		$join->on( 'notices.id', '=', 'user_read_notice.notice_id' )
						 			 ->where( 'user_read_notice.user_id', '=', Sentry::getUser()->user_id );

						 	})
						 	->where( 'notices.id', '<>', 'user_read_notice.notice_id' )
						 	->paginate( static::$default_per_page );

		$notices = $paginator->getCollection();

		$notices->each(function( $notice ){
			$notice['already_read'] = false;
		});

		return View::make( 'pages.message-center.message.message', [
			'paginator'		=> $paginator
		]);
	}

	//已读消息
	public function read(){

		// 需要分页
		$paginator = Notice::select( 'notices.id', 'notices.title', 'notices.created_at' )
						 	->leftJoin( 'user_read_notice', function( $join ){

						 		$join->on( 'notices.id', '=', 'user_read_notice.notice_id' );
						 	})
						 	->where( 'user_read_notice.user_id', Sentry::getUser()->user_id )
						 	->paginate( static::$default_per_page );

		$notices = $paginator->getCollection();

		$notices->each(function( $notice ){
			$notice['already_read'] = true;
		});

		return View::make( 'pages.message-center.message.message', [
			'paginator'		=> $paginator
		]);
	}

	//通知的详细内容
	public function detail(){

		$notice = Notice::find( Input::get('notice_id') );

		if ( !isset( $notice ) )
			return View::make( 'errors.missing' );

		return View::make( 'pages.message-center.message-center.detail', [
			'notice'	=> $notice
		]);
	}
}
