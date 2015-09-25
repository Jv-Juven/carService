<?php

class NoticePageController extends BaseController{
	
	//全部通知消息
	public function all(){

		// 需要分页
		$paginator = Notice::select( 'notice_id', 'title' )
						    ->with([
								'notice_user_id' => function( $query ){
									$query->where( 'user_id', Sentry::getUser()->user_id );
								}
						 	])->paginate();

		// 获取collection
		$notices = $paginator->getCollection();

		$notices->each(function( $notice ){

			$notice['already_read'] = isset( $notice->notice_user_id );
		})

		return View::make( 'pages.message-center.message.message', $notices );
	}

	// 获取未读消息
	public function unread(){

		// 需要分页
		$paginator = Notice::select( 'notice.notice_id', 'notice.title' )
						 	->leftJoin( 'user_read_notice', function( $join ){

						 		$join->on( 'notices.notice_id', '=', 'user_read_notice.notice_id' )
						 			->where( 'user_read_notice.user_id', '=', Sentry::getUser()->user_id );

						 	})
						 	->where( 'notice.notice_id', '<>', 'user_read_notice.notice_id' )
						 	->paginate();

		return View::make( 'pages.message-center.message.message', $paginator->getCollection() );
	}

	//已读消息
	public function read(){

		// 需要分页
		$paginator = Notice::select( 'notice_id', 'title' )
						 	->leftJoin( 'user_read_notice', function( $join ){

						 		$join->on( 'notices.notice_id', '=', 'user_read_notice.notice_id' )
						 			->where( 'user_read_notice.user_id', Sentry::getUser()->user_id );

						 	})->paginate();

		return View::make( 'pages.message-center.message.message', $paginator->getCollection() );
	}
}
