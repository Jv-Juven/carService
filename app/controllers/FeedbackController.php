<?php

class FeedbackController extends BaseController{

	public function index(){

		return View::make( 'pages.message-center.feedback.index' );
	}

	public function add_feedback(){

		$type 		= Input::get('type');
		$title 		= Input::get('title');
		$content 	= Input::get('content');

		if( !isset( $type ) ){

			return Response::json(array('errCode'=>1,'message'=>'请选者反馈类型'));
		}

		if( !isset( $title ) ){

			return Response::json(array('errCode'=>2,'message'=>'请输入标题'));
		}
			

		if( !isset( $content ) ){

			return Response::json(array('errCode'=>3,'message'=>'请输入内容'));
		}
			
		$feedback 			= new Feedback;
		$feedback->user_id 	= Sentry::getUser()->user_id;
		$feedback->type 	= $type;
		$feedback->title 	= $title;
		$feedback->content 	= $content;
		$feedback->status 	= 0;
		
		if ( !$feedback->save() )
			return Response::json(array('errCode'=>4,'message'=>'保存失败'));

		return Response::json(array('errCode'=>0,'message'=>'保存成功'));
	}

	public function feedback_success(){

		return View::make( 'pages.message-center.feedback.success' );
	}
}