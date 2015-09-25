<?php

class CostDetailController extends BaseController{

    public function overview(){

        return View::make( 'pages.finance-center.cost-manage.overview' );
    }

    public function cost_detail(){

        return View::make( 'pages.finance-center.cost-manage.cost-detail' );
    }

    public function refund_record(){

        return View::make( 'pages.finance-center.cost-manage.refund-record' );
    }
}