<?php

class OrderController extends BaseController{

    public function search(){

        if ( Input::has( 'order_id' ) ){

            $agency_order = [ AgencyOrder::with( 'traffic_violation_info' )
                                       ->find( Input::get( 'order_id' ) ) ];
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
                    if ( Input::has( 'start_date' ) ){
                        $query->where( 'req_event_time', '>=', Input::get( 'start_date' ) );
                    }else{
                        $query->where( 'req_event_time', '>=', date( 'Y-m-d', strtotime( '-1 year' ) ) );
                    }

                    if ( Input::has( 'end_date' ) ){
                        $query->where( 'req_event_time', '<=', Input::get( 'end_date' ) );
                    }

                    $query->orderBy( 'req_event_time', 'desc' );
                }
            ])->paginate( 3 );

            $agency_order = $paginator->getCollection();
        }

        return Response::json([ 'errCode' => 0, 'orders' => $agency_order ]); 
    }

    public function cancel(){

        $order_id = Input::get( 'order_id' );
        

        if ( empty( $order_id ) ){
            return Response::json([ 'errCode' => 2, 'message' => '无效参数' ]);
        }

        $agency_order = AgencyOrder::find( $order_id );

        if ( !isset( $agency_order ) || $agency_order->user_id != Sentry::getUser()->user_id ){
            return Response::json([ 'errCode' => 3, 'message' => '无效订单' ]);
        }

        if ( !( $agency_order->trade_status == '0' && $agency_order->process_status == '0' ) ){
            return Response::json([ 'errCode' => 4, 'message' => '无法删除该订单' ]);
        }

        if ( !$agency_order->delete() ){
            return Response::json([ 'errCode' => 1, 'message' => '删除失败' ]);
        }

        return Response::json([ 'errCode' => 0, 'message' => '删除成功' ]);
    }

    //申请退款
    public function requestRefund()
    {
        $order_id = Input::get('order_id');
        $order = AgencyOrder::find($order_id);

        if( !isset($order) )
            return Response::json(array('errCode'=>21, 'message'=>'该订单不存在'));
        
        $refund_record = RefundRecord::where('order_id','=',$order_id)->get();
        
        if( count($refund_record) != 0 )
            return Response::json(array('errCode'=>22, 'message'=>'申请已提交'));

        if( $order->trade_status != 1 || $order->process_status != 1 )
            return Response::json(array('errCode'=>23,'message'=>'该订单不可申请退款'));

        try{
            DB::transaction( function() use( $order ) {
                $order->trade_status = 2;
                $order->save();

                $refund_record = new RefundRecord;
                $refund_record->order_id = $order->order_id;
                $refund_record->user_id = Sentry::getUser()->user_id;
                $refund_record->save();
            });
        }catch( Exception $e)
        {
            return Response::json(array('errCode'=>24, 'message'=>'退款申请失败，请重新申请' ));
        }

        return Response::json(array('errCode'=>0,'message'=>'申请成功'));
    }

    

}