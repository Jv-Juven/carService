<?php

class SearchPageController extends BaseController{
    
    public function violation(){

        return View::make( 'pages.serve-center.data.violation' );
    }

    public function license(){

        return View::make( 'pages.serve-center.data.drive' );
    }

    public function car(){

        return View::make( 'pages.serve-center.data.cars' );
    }
}