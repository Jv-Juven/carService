<?php

class NoticeController extends BaseController{

    public function read_notice(){
        
        $notice_id = Input::get( 'notice_id' );
        $user_id   = Sentry::getUser()->user_id;

        // 判断该用户是否已读该条记录
        if ( UserReadNotice::where( 'user_id', $user_id )
                           ->where( 'notice_id', $notice_id )
                           ->count() ){
            return Response::json([ 'errCode' => 2, 'message' => '已读该条记录' ]);
        }

        $user_read_notice               = new UserReadNotice();
        $user_read_notice->user_id      = $user_id;
        $user_read_notice->notice_id    = $notice_id;

        // 保存
        if ( !$user_read_notice->save() ){
            return Response::json([ 'errCode' => 1, 'message' => 'Done' ]);
        }

        return Response::json([ 'errCode' => 0, 'message' => 'ok' ]);
    }
}