<?php

use Carbon\Carbon as Carbon;

class CostManageController extends BaseController{

    public static $default_per_page = 7;

    public function overview(){

        if ( Sentry::getUser()->is_common_user() ){

            return View::make( 'pages.finance-center.cost-manage.overview' );

        }else if ( Sentry::getUser()->is_business_user() ){

            return View::make( 'pages.finance-center.cost-manage.overview', [
                
                'account_info' => BusinessController::accountInfo()
            ]);
        }

        return 'Error';
    }

    public function cost_detail(){

        // 默认渲染数据
        $render_data = [
            'previous_input' => [
                'date'          => '',
                'cost_type'     => '10'
            ],
            'results'         => []
        ];

        $params = Input::all();

        // 参数非空，且指定查询的消费类型，且指定的消费类型有效
        if ( !empty( $params ) ){

            // 默认第一页
            if ( !Input::has( 'page' ) ){
                $params['page'] = 1;
            }

            if ( !Input::has( 'date' ) ){
                $params['date'] = date( 'Y-m' );
            }

            Input::merge( $params );

            $render_data['previous_input']  = array_merge( $render_data['previous_input'], $params );

            // 查询充值记录
            if ( $params['cost_type'] == '10' ){

                // 先查询费用类型
                $fee_type = FeeType::select( 'id', 'category', 'item' )
                                    ->where( 'category', '10' )->first();

                // 查询费用明细所必须条件
                $render_data['results'] = CostDetail::select( 'cost_id', 'created_at', 'fee_type_id', 'number' )
                                   ->where( 'user_id', Sentry::getUser()->user_id )
                                   ->where( 'fee_type_id', $fee_type->id )
                                   ->where( 'created_at', 'like', $params['date'].'%' )
                                   ->orderBy( 'created_at', 'desc' )
                                   ->get();
            }
            // 查询查询记录
            else if ( $params['cost_type'] == '20' ){

                $date = Carbon::parse( Input::get( 'date' ) );
                $date_start = $date->timestamp * 1000;
                $date->addMonth();
                $date_end   = $date->timestamp * 1000;

                $render_data['results'] = BusinessController::count( Sentry::getUser()->user_id, $date_start, $date_end );
            }
        }

        return View::make( 'pages.finance-center.cost-manage.cost-detail', $render_data );
    }

    public function refund_record(){

        $paginator = RefundRecord::where( 'user_id', Sentry::getUser()->user_id )
                                 ->paginate( static::$default_per_page );

        return View::make( 'pages.finance-center.cost-manage.refund-record', [
            'records'       => $paginator->getCollection(),
            'paginator'     => $paginator
        ]);
    }
}