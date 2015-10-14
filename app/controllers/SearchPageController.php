<?php

class SearchPageController extends BaseController{
    
    public function violation(){

        if ( Sentry::check() ){
            
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

            return View::make( 'pages.serve-center.data.violation', [ 'account' => $account_to_render ] );
        }
        else{

            return View::make( 'pages.serve-center.data.violation' );
        }        
    }

    public function license(){

        $user = Sentry::getUser();

        if ( $user->is_common_user() ){

            return View::make( '404' );
        }

        $account = BusinessController::accountInfo( $user->user_id );

        $account['unit'] = $account['licenseUnit'];

        return View::make( 'pages.serve-center.data.drive', [ 'account' => $account ]);
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