<?php

class AgencyController extends BaseController{

    public static $AGENCY_STATUS_SEARCHED    = 0;
    public static $AGENCY_STATUS_CONFIRMED   = 1;

    protected static function get_total_fee( $violations ){

        $total_fee = 0;

        foreach ( $violations as $violation ){
            $total_fee += (int)$violation[ 'fkje' ];
        }

        return $total_fee;
    }
    
    public function confirm_violation(){

        if ( !Session::has( 'violations' ) ){
            return Response::json([ 'errCode' => 1, 'message' => '请先查询' ]);
        }

        $sequences = Input::get( 'xh' );

        if ( empty( $sequences ) ){
            return Response::json([ 'errCode' => 2, 'message' => '请选择需要办理的订单' ]);
        }

        if ( !is_array( $sequences ) ){
            return Response::json([ 'errCode' => 3, 'message' => '参数错误' ]);
        }

        $violations = Session::get( 'violations' );

        $sign = Input::get( 'sign' );

        // 检测sign值
        if ( !array_key_exists( $sign, $violations ) ){

            return Response::json([ 'errCode' => 3, 'message' => '参数错误' ]);
        }

        // 判断状态码
        if ( $violations[ $sign ][ 'info' ][ 'status' ] == static::$AGENCY_STATUS_CONFIRMED ){

            return Response::json([ 'errCode' => 4, 'message' => '您已确认办理' ]);
        }

        // 根据违章序号过滤出需要代办的记录
        $violations_to_process = array_filter( $violations[ $sign ]['results'], function( $violation ) use ( $sequences ){

            return in_array( $violation['xh'], $sequences );
        });

        // 检查是否为空
        if ( !count( $violations_to_process ) ){
            return Response::json([ 'errCode' => 3, 'message' => '参数错误' ]);
        }

        // 保存到session
        $violations[ $sign ][ 'info' ][ 'status' ] = static::$AGENCY_STATUS_CONFIRMED;
        $violations[ $sign ][ 'info' ][ 'count' ] = count( $violations_to_process );
        $violations[ $sign ][ 'info' ][ 'total_fee' ] = static::get_total_fee( $violations_to_process );
        $violations[ $sign ][ 'results' ] = $violations_to_process;

        Session::put( 'violations', $violations );

        return Response::json([ 'errCode' => 0, 'message' => 'ok', 'sign' => $sign ]);
    }

    public function cancel_violation(){

        $message = [ 'errCode' => 0, 'message' => 'ok' ];

        if ( !Session::has( 'violations' ) ){
            return Response::json( $message );
        }

        $violations = Session::get( 'violations' );

        $sign = Input::get( 'sign' );

        if ( array_key_exists( $sign, $violations ) ){
            unset( $violations[ $sign ] );    
        }

        Session::put( 'violations', $violations );

        return Response::json( $message );
    }

    public function submit_order(){

        if ( !Session::has( 'violations' ) ){
            return Response::json([ 'errCode' => 2, 'message' => '请先查询并确认代办' ]);
        }

        $violations = Session::get( 'violations' );

        $sign = Input::get( 'sign' );

        if ( !array_key_exists( $sign, $violations ) ){
            return Response::json([ 'errCode' => 3, 'message' => '参数错误' ]);
        }

        if ( $violations[ $sign ][ 'info' ][ 'status' ] != static::$AGENCY_STATUS_CONFIRMED ){
            return Response::json([ 'errCode' => 2, 'message' => '请先确认' ]);
        }

        if ( ( $is_delivered = (int)Input::get( 'is_delivered' ) ) ){
            $params = Input::all();
            $rules  = [
                'recipient_name'    => 'required',
                'recipient_addr'    => 'required',
                'recipient_phone'   => 'required|telephone'
                //'car_engine_no'     => 'required'
            ];
            $message = [ 
                'required'          => '请输入:attribute',
                'telephone'         => ':attribute格式不正确'
            ];
            $attributes = [
                'recipient_name'    => '收件人姓名',
                'recipient_addr'    => '收件人地址',
                'recipient_phone'   => '收件人手机'
            ];

            $validator = Validator::make( $params, $rules, $message, $attributes );

            if ( $validator->fails() ){
                return Response::json([ 'errCode' => 4, 'message' => $validator->messages()->first() ]);
            }
        }

        $violation = $violations[ $sign ];

        try{
            DB::beginTransaction();

            $order_id                           = AgencyOrder::get_unique_id();
            $agency_order                       = new AgencyOrder();
            $agency_order->order_id             = $order_id;
            $agency_order->user_id              = Sentry::getUser()->user_id;
            $agency_order->agency_no            = $violation['info']['count'];
            $agency_order->capital_sum          = $violation['info']['total_fee'];
            $agency_order->car_type_no          = $violation['info']['car_type_no'];
            $agency_order->car_plate_no         = $violation['info']['car_plate_no'];
            $agency_order->car_engine_no        = $violation['info']['car_engine_no'];
            $agency_order->service_charge_sum   = $violation['info']['service_fee'] * $violation['info']['count'];
            $agency_order->late_fee_sum         = 0.00;
            $agency_order->trade_status         = 0;
            $agency_order->process_status       = 0;

            if ( $is_delivered ){
                $agency_order->is_delivered     = true;
                $agency_order->express_fee      = $violation['info']['express_fee'];
                $agency_order->recipient_name   = $params['recipient_name'];
                $agency_order->recipient_addr   = $params['recipient_addr'];
                $agency_order->recipient_phone  = $params['recipient_phone'];
            }

            $agency_order->save();

            foreach ( $violation['results'] as $violation_result ){
                $violation_info = new TrafficViolationInfo();
                $violation_info->order_id               = $order_id;
                $violation_info->req_car_frame_no       = '';
                $violation_info->req_car_plate_no       = $violation_result['hphm'];   //车牌号码
                $violation_info->req_car_engine_no      = $violation_result['fdjh'];   //发动机号后六位
                $violation_info->car_type_no            = $violation_result['hpzl'];   //号牌种类
                $violation_info->rep_event_time         = $violation_result['wfsj'];   //违法时间
                $violation_info->rep_event_addr         = $violation_result['wfdz'];   //违法地址
                $violation_info->rep_violation_behavior = $violation_result['wfxwzt']; //违法行为
                $violation_info->rep_point_no           = $violation_result['wfjfs'];  //违法记分数
                $violation_info->rep_priciple_balance   = $violation_result['fkje'];   //罚款金额
                $violation_info->rep_service_charge     = $violation['info']['service_fee'];
                $violation_info->save();
            }

            DB::commit();

        }catch( Exception $e ){

            DB::rollback();

            throw $e;

            return Response::json([ 'errCode' => 1, 'message' => '订单处理失败' ]);
        }

        unset( $violations[ $sign ] );
        Session::put( 'violations', $violations );

        return Response::json([ 'errCode' => 0, 'message' => 'ok', 'order_id' => $order_id ]);
    }
}