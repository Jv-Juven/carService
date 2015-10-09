<?php

class AgencyPageController extends BaseController{
    
    public function search_violation(){

        return View::make( 'pages.serve-center.business.vio' );
    }

    protected function get_total_fee( $violations ){

        $total_fee = 0;

        foreach ( $violations as $violation ){
            $total_fee += (int)$violation[ 'fkje' ];
        }

        return $total_fee;
    }

    public function agency(){

        if ( !Session::has( 'violations_to_process' ) ){

            return Redirect::to( '/serve-center/agency/pages/search_violation' );
        }

        $violations = Session::get( 'violations' );
        $violations['info'][ 'count' ] = count( $violations['results'] );
        $violations['info'][ 'total_fee' ] = $this->get_total_fee( $violations['results'] );

        $agency_info = [
            'service_fee'   => BusinessController::getServiceFee() * $violations_info['count'],
            'express_fee'   => BusinessController::getExpressFee()
        ];

        Session::put( 'violations', $violations );
        Session::put( 'agency_info', $agency_info );

        return View::make( 'pages.serve-center.business.agency', [
            'violations_info'       => $violations_info,
            'agency_info'           => $agency_info
        ]);
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