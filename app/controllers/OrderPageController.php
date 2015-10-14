<?php

class OrderPageController extends BaseController{
    
    public function violation(){

        $paginator = AgencyOrder::where( 'user_id', Sentry::getUser()->user_id )
                                ->with( 'traffic_violation_info' )
                                ->orderBy( 'created_at', 'desc' )
                                ->paginate( 5 );

        return View::make( 'pages.serve-center.indent.indent-agency', [
            'paginator'     => $paginator,
            'order_status'  => Config::get( 'order_status' )
        ]);
    }
}