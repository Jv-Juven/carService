<?php

class CostManageController extends BaseController{

    public static $default_per_page = 7;

    public function overview(){

        $account = BusinessController::accountInfo();

        if ( $account['errCode'] ){
            return View::make( $account['message'] );
        }

        return View::make( 'pages.finance-center.cost-manage.overview', [
            'account_info' => $account['account']
        ]);
    }

    public function cost_detail(){

        // 默认渲染数据
        $render_data = [
            'previous_input' => [
                'date_start'    => '',
                'date_end'      => '',
                'cost_type'     => '10'
            ],
            'paginator'         => [],
            'cost_types'      => FeeType::get_all_category()
        ];

        $params = Input::all();

        // 参数非空，且指定查询的消费类型，且指定的消费类型有效
        if ( !empty( $params ) && Input::has( 'cost_type' ) && FeeType::is_category_exists( Input::get( 'cost_type' ) ) ){

            // 默认第一页
            if ( !Input::has( 'page' ) ){
                Input::merge([ 'page' => 1 ]);
            }

            // 先查询费用类型
            $fee_types = FeeType::select( 'id', 'category', 'item' )
                                ->where( 'category', Input::get( 'cost_type' ) )
                                ->get();

            // 去除id
            $fee_type_ids = [];
            foreach ( $fee_types as $fee_type ){
                array_push( $fee_type_ids, $fee_type->id );
            }

            // 查询费用明细所必须条件
            $query = CostDetail::select( 'cost_id', 'created_at', 'fee_type_id', 'number' )
                               ->where( 'user_id', Sentry::getUser()->user_id )
                               ->whereIn( 'fee_type_id', $fee_type_ids )
                               ->orderBy( 'created_at' );

            // 检测起止日期
            if ( Input::has( 'date_start' ) ){
                $query->where( 'created_at', '>=', Input::get( 'date_start' ) );
            }
            if ( Input::has( 'date_end' ) ){
                $query->where( 'created_at', '<=', Input::get( 'date_end' ) );
            }

            $paginator = $query->paginate( static::$default_per_page );

            // 费用类型转换：代号->名称
            $fee_types->each(function( $fee_type ){
                $fee_type_format      = FeeType::get_category_and_subitem_names( $fee_type->category, $fee_type->item );
                $fee_type->category   = $fee_type_format[ 'category' ];
                $fee_type->item       = $fee_type_format[ 'item' ];
            });

            // 重新组合
            $fee_types = array_combine( $fee_type_ids, $fee_types->toArray() );

            $render_data['previous_input']  = array_merge( $render_data['previous_input'], $params );

            // 分页 --- 预添加查询参数
            foreach ( $render_data['previous_input'] as $query_key => $query_value ){
                $paginator->addQuery( $query_key, $query_value );
            }

            $render_data['fee_types']       = $fee_types;
            $render_data['paginator']       = $paginator;
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