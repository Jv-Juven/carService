<?php

class AgencyPageController extends BaseController{
    
    public function search_violation(){

        return View::make( 'pages.serve-center.business.vio' );
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

        return View::make( 'pages.serve-center.business.agency', [ 'violations_info' => $$violation[ $sign ]['info'] ]);
    }

    public function pay(){

        if ( Session::has( 'order_info' ) ){

            return View::make( 'pages.serve-center.business.pay', Session::get( 'order_info' ) );
        }

        $agency_order = AgencyOrder::find( Input::get( 'order_id' ) );

        if ( !isset( $agency_order ) ){
            return Response::make( '无效order_id' );
        }

        return View::make( 'pages.serve-center.business.pay', $agency_order );
    }
}