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

    public function fail()
    {   
        $order_id = Input::get('order_id');
        $order = AgencyOrder::find( $order_id );
        if( !isset($order) )
            return Response::make( 'Invalid order' );

        if ( $order->user_id != Sentry::getUser()->user_id )
            return Response::make( 'Invalid order' );
        
        if( $order->trade_status == '2' || $order->trade_status == '3' )
            return Response::make( 'Invalid order' );


        return View::make('pages.serve-center.pay.fail')->with(array('order'=>$order));
    }

    public function success()
    {
        $order_id = Input::get('order_id');
        $order = AgencyOrder::find( $order_id );
        if( !isset($order) )
            return Response::make( 'Invalid order' );

        if ( $order->user_id != Sentry::getUser()->user_id )
            return Response::make( 'Invalid order' );
        
        if( $order->trade_status == '2' || $order->trade_status == '3' )
            return Response::make( 'Invalid order' );

        return View::make('pages.serve-center.pay.success')->with(array('order'=>$order));
    }
}