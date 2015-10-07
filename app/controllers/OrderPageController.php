<?php

class OrderPageController extends BaseController{
    
    public function violation(){

        $paginator = AgencyOrder::where( 'user_id', Sentry::getUser()->user_id )
                                ->orderBy( 'created_at' )
                                ->paginate( 3 );

        return View::make( 'pages.serve-center.indent', [
            'paginator' => $paginator
        ]);
    }
}