<?php

class OrderController extends BaseController{

    public function search(){

        if ( Input::has( 'order_id' ) ){

            $agency_order = AgencyOrder::with( 'traffic_violation_info' )
                                       ->find( Input::get( 'order_id' ) );
        }else{

            $query = AgencyOrder::select( '*' );

            if ( Input::has( 'car_plate_no' ) ){
                $query->where( 'car_plate_no', Input::get( 'car_plate_no' ) );
            }

            if ( Input::has( 'car_type_no' ) ){
                $query->where( 'car_type_no', Input::get( 'car_type_no' ) );
            }

            if ( Input::has( 'process_status' ) ){
                $query->where( 'process_status', Input::get( 'process_status' ) );
            }

            $paginator = $query->with([
                'traffic_violation_info' => function( $query ){

                    if ( Input::has( 'city' ) ){
                        $query->where( 'req_event_city', Input::get( 'city' ) );
                    }

                    // 没有选择开始日期，则从查询至一年前为止
                    if ( Input::has( 'from' ) ){
                        $query->where( 'req_event_time', '>=', Input::get( 'from' ) );
                    }else{
                        $query->where( 'req_event_time', '>=', date( 'Y-m-d', strtotime( '-1 year' ) ) );
                    }

                    if ( Input::has( 'to' ) ){
                        $query->where( 'req_event_time', '<=', Input::get( 'to' ) );
                    }

                    $query->orderBy( 'req_event_time' );
                }
            ])->paginate( 3 );

            $agency_order = $paginator->getCollection();
        }

        return Response::json([ 'errCode', 'orders' => $agency_order ]); 
    }

    public function cancel(){

        if ( !AgencyOrder::destroy( Input::get( 'order_id' ) ) ){
            return Response::json([ 'errCode' => 1, '删除失败' ]);
        }

        return Response::json([ 'errCode' => 0, '删除成功' ]);
    }
}