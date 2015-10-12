<?php

class SearchPageController extends BaseController{
    
    public function violation(){

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

        return View::make( 'pages.serve-center.data.violation', [ 'account' => $account_to_render ] );
    }

    public function license(){

        $user = Sentry::getUser();

        if ( $user->is_common_user() ){

            return View::make( '404' );
        }

        return View::make( 'pages.serve-center.data.drive', [
            'account' => BusinessController::accountInfo( $user->user_id )
        ]);
    }

    public function car(){

        $user = Sentry::getUser();

        if ( $user->is_common_user() ){

            return View::make( '404' );
        }

        $account = BusinessController::accountInfo( $user->user_id );

        $account['unit'] = $account['carUnit'];

        return View::make( 'pages.serve-center.data.cars', [ 'account' => $account ]);
    }
}