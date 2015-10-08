<?php

class AgencyController extends BaseController{
    
    public function confirm_violation(){

        if ( !Session::has( 'violations' ) ){
            return Response::json([ 'errCode' => 1, 'message' => '请先查询' ]);
        }

        $sequences = Input::get( 'xh' );

        if ( empty( $sequences ) ){
            return Response::json([ 'errCode' => 2, 'message' => '请选择需要办理的订单' ])
        }

        if ( !( $sequences instanceof array ) ){
            return Response::json([ 'errCode' => 3, 'message' => '参数错误' ]);
        }

        $violations = Session::get( 'violations' );

        // 根据违章序号过滤出需要代办的记录
        $violations_to_process = array_filter( $violations['result'], function( $violation ){

            return in_array( $violation['xh'], $sequences );
        });

        // 检查是否为空
        if ( empty( $violations_to_process ) ){
            return Response::json([ 'errCode' => 3, 'message' => '参数错误' ]);
        }

        // 保存到session
        $violations['result'] = $violations_to_process;
        Session::put( 'violations', $violations );

        return Response::json([ 'errCode' => 0, 'message' => 'ok' ]);
    }

    public function submit_order(){

        if ( !( Session::has( 'violations' ) && Session::has( 'agency_info' ) ) ){
            return Response::json([ 'errCode' => 1, 'message' => '请先查询并确认代办' ]);
        }

        if ( Input::has( 'is_delivered' ) && ( $is_delivered = Input::get( 'is_delivered' ) ) == true ){
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
                'recipient_addr'    => '收件人地址'
                'recipient_phone'   => '收件人手机'
            ];

            $validator = Validator::make( $params, $rules, $message, $attributes );

            if ( $validator->fails() ){
                return Response::json( 'errCode' => 2,'messages' => $validator->messages()->all() );
            }
        }

        $violations = Session::get( 'violations' );
        $agency_info = Session::get( 'agency_info' );

        try{
            DB::beginTransaction();
            $order_id                           = AgencyOrder::get_unique_id();
            $agency_order                       = new AgencyOrder();
            $agency_order->order_id             = $order_id;
            $agency_order->user_id              = Sentry::getUser()->user_id;
            $agency_order->capital_sum          = $violations['info']['total_fee'];
            $agency_order->car_type_no          = $violations['info']['car_type_no'];
            $agency_order->car_plate_no         = $violations['info']['car_plate_no'];
            $agency_order->car_engine_no        = $violations['info']['car_engine_no'];
            $agency_order->service_charge_sum   = $agency_info['service_fee'];
            $agency_order->trade_status         = 0;
            $agency_order->process_status       = 0;

            if ( $is_delivered ){
                $agency_order->is_delivered     = true;
                $agency_order->express_fee      = $agency_info['express_fee'];
                $agency_order->recipient_name   = $params['recipient_name'];
                $agency_order->recipient_addr   = $params['recipient_addr'];
                $agency_order->recipient_phone  = $params['recipient_phone'];
            }

            $agency_order->save();

            foreach ( $violations['result'] as $violation_result ){
                $violation_info = new TrafficViolationInfo();
                $violation_info->order_id               = $order_id;
                $violation_info->req_car_plate_no       = $violation['hphm'];   //车牌号码
                $violation_info->req_car_engine_no      = $violation['fdjh'];   //发动机号后六位
                $violation_info->car_type_no            = $violation['hpzl'];   //号牌种类
                $violation_info->rep_event_time         = $violation['wfsj'];   //违法时间
                $violation_info->rep_event_addr         = $violation['wfdz'];   //违法地址
                $violation_info->rep_violation_behavior = $violation['wfxwzt']; //违法行为
                $violation_info->rep_point_no           = $violation['wfjfs'];  //违法记分数
                $violation_info->rep_priciple_balance   = $violation['fkje'];   //罚款金额
                $violation_info->rep_service_charge     = $agency_info['service_fee'];
                $violation_info->save();
            }

            DB::commit();

        }catch( Exception $e ){

            DB::rollback();

            return Response::json([ 'errCode' => 3, 'message' => '订单处理失败' ]);
        }
        
        Session::forget( 'violations' );
        Session::forget( 'agency_order' );

        $result = [
            'order_id'              => $order_id,
            'agency_no'             => $violations['info']['count'],
            'capital_sum'           => $violations['info']['total_fee'],
            'car_plate_no'          => $violations['info']['car_plate_no'],
            'service_charge_sum'    => $agency_order['service_fee']
        ];

        if ( $is_delivered ){
            $result['recipient_name']   => $params['recipient_name'];
            $result['recipient_addr']   => $params['recipient_addr'];
            $result['recipient_phone']  => $params['recipient_phone'];
        }

        Session::flash( 'order_info', $result );

        return Response::json([
            'errCode'       => 0,
            'message'       => 'ok',
            'order'         => $result
        ]);
    }
}