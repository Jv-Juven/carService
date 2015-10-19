<?php

class NoticePageController extends BaseController{

	protected static $default_per_page = 7;

	/**
	 * 获取公告分页后结果
	 * 
	 * @return Collection
	 */
	protected function get_paginated_notice( $user_id = null ){

		return  Notice::select( 'id', 'title', 'created_at' )
					  	->with([
							'users_read_id' => function( $query ) use ( $user_id ){

								$query->select( 'notice_id' );

								if ( !is_null( $user_id ) ){
									$query->where( 'user_id', $user_id );
								}
							}
					 	])
					 	->orderBy( 'created_at', 'desc' )
					 	->paginate( static::$default_per_page );
	}

	// 主页公告
	public function home(){

		$paginator = $this->get_paginated_notice();

		return View::make( 'pages.message-center.message.home', [
			'notices'		=> $paginator->getCollection(),
			'paginator'		=> $paginator
		]);
	}
	
	//全部通知消息
	public function all(){

		// 获取notices
		$paginator = $this->get_paginated_notice( Sentry::getUser()->user_id );

		$notices = $paginator->getCollection();
		$notices->each(function( $notice ){

			$notice['already_read'] = $notice->users_read_id->count() != 0;
		});

		return View::make( 'pages.message-center.message.message', [
			'notices'		=> $notices,
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
						 	->whereNull( 'user_read_notice.notice_id' )
						 	->orderBy( 'created_at', 'desc' )
						 	->paginate( static::$default_per_page );

		$notices = $paginator->getCollection();

		return View::make( 'pages.message-center.message.message', [
			'notices'		=> $notices,
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
						 	->orderBy( 'created_at', 'desc' )
						 	->paginate( static::$default_per_page );

		$notices = $paginator->getCollection();

		return View::make( 'pages.message-center.message.message', [
			'notices'		=> $notices,
			'paginator'		=> $paginator
		]);
	}

	//通知的详细内容
	public function detail(){

		$notice_id = Input::get( 'notice_id' );
		$notice = Notice::find( Input::get('notice_id') );

		if ( !isset( $notice ) )
			return View::make( 'errors.missing' );

		// 用户登陆，标记为已读
		if ( Sentry::check() ){

			$user_id = Sentry::getUser()->user_id;

			// 先查询是否已标记为已读
			if ( UserReadNotice::where( 'user_id', $user_id )
                           	   ->where( 'notice_id', $notice_id )
                               ->count() == 0 ){
				$user_read_notice               = new UserReadNotice();
       			$user_read_notice->user_id      = $user_id;
        		$user_read_notice->notice_id    = $notice_id;

        		// 保存。不成功，下次读取依旧判断
        		// 需改进 ？？？
        		$user_read_notice->save();
			}
		}

		return View::make( 'pages.message-center.message.detail', [
			'notice'	=> $notice
		]);
	}
}
