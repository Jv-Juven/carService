<?php

class RechargeController extends BaseController{

    public function index(){

        return View::make( 'pages.finance-center.recharge.index' );
    }
}