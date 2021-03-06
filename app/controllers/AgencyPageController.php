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

        $user = Sentry::getUser();

        $agency_user_attr = '';

        if ( $user->is_common_user() ){

            $agency_user_attr = $user->login_account;
        }
        else if ( $user->is_business_user() ){

            $agency_user_attr = BusinessUser::find( $user->user_id )->business_name;
        }

        return View::make( 'pages.serve-center.business.agency', [ 
            'sign'              => $sign, 
            'agency_user_attr'  => $agency_user_attr,
            'agency_info'       => $violations[ $sign ]['info'] 
        ]);
    }

    public function pay(){

        $agency_order = AgencyOrder::find( Input::get( 'order_id' ) );

        if ( !isset( $agency_order ) ){
            return Response::make( '无效参数' );
        }

        if ( $agency_order->trade_status != '0' ){
            return Response::make( '该订单已付款' );
        }

        return View::make( 'pages.serve-center.business.pay', [ 'order' => $agency_order ]);
    }
}