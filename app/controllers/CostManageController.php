<?php

class CostDetailController extends BaseController{

    public static $default_per_page = 12;

    public function overview(){

        return View::make( 'pages.finance-center.cost-manage.overview' );
    }

    public function cost_detail(){

        return View::make( 'pages.finance-center.cost-manage.cost-detail' );
    }

    public function refund_record(){

        $paginator = RefundRecord::where( 'user_id', Sentry::getUser()->user_id )
                                 ->paginate( static::$default_per_page );

        return View::make( 'pages.finance-center.cost-manage.refund-record', [
            'records' => $paginator->getCollection()
        ]);
    }
}