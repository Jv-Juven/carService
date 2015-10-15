<?php

use Carbon\Carbon as Carbon;

class OrderController extends BaseController{

    public function search(){

	$order_id = Input::get( 'order_id'  );
        if ( !empty( $order_id ) ){

            $agency_orders = [ AgencyOrder::with( 'traffic_violation_info' )
                                       ->find( $order_id ) ];
        }else{

            $query = AgencyOrder::select( '*' );

            $car_plate_no = Input::get( 'car_plate_no' );    
            if ( !empty( $car_plate_no ) ){
                $query->where( 'car_plate_no', $car_plate_no );
            }

            $process_status = Input::get('process_status');
            if ( $process_status !='' || $process_status != null ){
		$query->where( 'process_status', $process_status );  //  (string)$process_status );
            }


	    $start_date = Input::get( 'start_date' );
            if ( !empty( $start_date ) ){
                $query->where( 'created_at', '>=', Carbon::parse( $start_date )->toDateTimeString()  );
            }else{
                $query->where( 'created_at', '>=', Carbon::now()->subYear()->toDateTimeString() );
            }

            $end_date = Input::get( 'end_date' );
            if ( !empty( $end_date ) ){
                $query->where( 'created_at', '<=', Carbon::parse( $end_date )->addDay()->toDateTimeString() );
            }

            $agency_orders = $query->with( 'traffic_violation_info' )->orderBy( 'created_at', 'desc' )->get();
        }

        return Response::json([ 'errCode' => 0, 'orders' => $agency_orders ]); 
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

    //订单状态
    public static function orderTradeStatus( )
    {
        $order_id = Input::get('order_id');
        $order = AgencyOrder::find($order_id);
        if( !isset($order) )
            return Response::json(array('errCode'=>21, 'message'=>'该订单不存在'));
        return Response::json(array('errCode'=>0, 'trade_status'=>$order->trade_status));
    }
    

}
