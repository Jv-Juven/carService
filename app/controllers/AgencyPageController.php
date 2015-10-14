<?php

class AgencyPageController extends BaseController{
    
    public function search_violation(){

        $user = Sentry::getUser();

        // 普通用户每天只能查询两次
        if ( $user->is_common_user() ){
            
            $account_to_render = [
                'remain_search'   => SearchController::get_search_count_remain( $user->user_id, 'violation' )
            ];
        }
        // 企业用户根据余额
        else if( $user->is_business_user() ){

            $account = BusinessController::accountInfo( $user->user_id );
            
            $account_to_render = [
                'unit'      => $account[ 'violationUnit' ],
                'balance'   => $account[ 'balance' ]
            ];
        }
        else{

            return View::make( 'Unkown error' );
        }

        return View::make( 'pages.serve-center.business.vio', [ 'account' => $account_to_render ] );
    }

    public function agency(){

        if ( !Session::has( 'violations' ) ){

            return Redirect::to( '/serve-center/agency/pages/search_violation' );
        }

        $violations = Session::get( 'violations' );

        $sign = Input::get( 'sign' );

        if ( !array_key_exists( Input::get( 'sign' ), $violations ) ){

            return Response::make( '参数错误' );
        }

        return View::make( 'pages.serve-center.business.agency', [ 'agency_info' => $violations[ $sign ]['info'] ]);
    }

    public function pay(){
/*
        if ( Session::has( 'order_info' ) ){

            return View::make( 'pages.serve-center.business.pay', Session::get( 'order_info' ) );
        }
*/
        $agency_order = AgencyOrder::find( Input::get( 'order_id' ) );

        if ( !isset( $agency_order ) ){
            return Response::make( '无效order_id' );
        }

        return View::make( 'pages.serve-center.business.pay', [ 'order' => $agency_order ]);
    }
}