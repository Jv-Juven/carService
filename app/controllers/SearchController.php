<?php

class SearchController extends BaseController{

    protected static $common_user_search_limit = 2;

    // 仅针对普通用户，可改进。
    // 每种查询每天不能超过两次。
    protected static function is_reach_search_limit( $user, $type ){

        $cache_key = static::get_search_key( $user, $type );

        $count = Cache::get( $cache_key, 0 );

        return $count <= static::$common_user_search_limit;
    }

    protected static function increase_search_count( $user, $type ){

        $cache_key = static::get_search_key( $user, $type );

        $count = Cache::get( $cache_key, 0 );

        if ( empty( $count ) ){

            Cache::put( $cache_key, 1 );
        }
        else if ( $count <= static::$common_user_search_limit ){

            Cache::put( $cache_key, $count + 1 );
        }
    }

    protected static function get_search_key( $user, $type ){

        return 'search_count_'.$type.'_'.$user->user_id;
    }
    
    public function violation(){

        $current_user = Sentry::getUser();

        if ( $current_user->is_common_user() && static::is_reach_search_limit( $current_user, 'violation' ) ){
            return Response::json([ 'errCode' => 2, '您已经达到查询上限。每日可查询2次' ]);
        }
        
        $params = Input::all();

        $rules = [
            'req_car_plate_no'  => 'required|size:7',
            'req_car_engine_no' => 'required|size:6',
            'car_type_no'       => 'required|size:2'
        ];

        $messages = [
            'required'          => '请输入:attribute',
            'size'              => ':attribute位数不正确'
        ];

        $attributes = [
            'req_car_engine_no' => '发动机号',
            'req_car_plate_no'  => '车牌号码',
            'car_type_no'       => '车辆类型'
        ];

        $validator = Validator::make( $params, $rules, $messages, $attributes );

        // 格式不对，将所有错误信息返回        
        if ( $validator->fails() ){

           return Response::json([ 'errCode' => 1, 'messages' => $validator->messages()->all() ]); 
        }

        // 发送请求
        try{

            $violation_result = BusinessController::violation(
                TokenController::getAccessToken( Sentry::getUser() ),
                $params['req_car_engine_no'],
                $params['req_car_plate_no'],
                $params['car_type_no']
            );

            // 违章信息存到session，以便下单
            // 没有违章记录则不保存
            if ( count( $violation_result ) ){

                Session::put( 'violations', [
                    'info'      => [
                        'car_type_no'       => $params['car_type_no'],
                        'car_plate_no'      => $params['req_car_plate_no'],
                        'car_engine_no'     => $params['req_car_engine_no']
                    ],
                    'results'   => $violation_result
                ]);
            }
        }
        catch( \Exception $e ){

            return Response::json([ 'errCode' => $e->getCode(), 'message' => $e->getMessage() ]);
        }

        return Response::json([ 'errCode' => 0, 'violations' => $violation_result ]);
    }

    public function license(){

        if ( Sentry::getUser()->is_common_user() ){
            return Response::json([ 'errCode' => 2, '无权限' ]);
        }

        $params = Input::all();

        $rules = [
            'identityId'        => 'required|id_card',
            'recordID'          => 'required'
        ];

        $messages = [
            'required'          => '请输入:attribute',
            'id_card'           => ':attribute格式不正确'
        ];

        $attributes = [
            'identityId'        => '身份证号',
            'recordID'          => '档案号码'
        ];

        $validator = Validator::make( $params, $rules, $messages, $attributes );

        // 格式不对，将所有错误信息返回        
        if ( $validator->fails() ){

           return Response::json([ 'errCode' => 1, 'messages' => $validator->messages()->all() ]); 
        }

        try{
            $license_result = BusinessController::license(
                TokenController::getAccessToken( Sentry::getUser() ),
                $params['identityId'],
                $params['recordID']
            );
        }
        catch( \Exception $e ){

            return Response::json([ 'errCode' => $e->getCode(), 'message' => $e->getMessage() ]);
        }

        return Response::json([ 'errCode' => 0, 'violations' => $license_result ]);
    }

    public function car(){

        if ( Sentry::getUser()->is_common_user() ){
            return Response::json([ 'errCode' => 2, '无权限' ]);
        }

        $params = Input::all();

        $rules = [
            'engineCode'        => 'required|size:6',
            'licensePlate'      => 'required|size:7',
            'licenseType'       => 'required|size:2'
        ];

        $messages = [
            'required'          => '请输入:attribute',
            'size'              => ':attribute位数不正确'
        ];

        $attribute = [
            'engineCode'        => '发动机号后6位',
            'licensePlate'      => '车牌号码',
            'licenseType'       => '车辆类型'
        ];

        $validator = Validator::make( $params, $rules, $messages, $attributes );

        // 格式不对，将所有错误信息返回        
        if ( $validator->fails() ){

           return Response::json([ 'errCode' => 1, 'messages' => $validator->messages()->all() ]); 
        }

        try{
            $car_result = BusinessController::car(
                TokenController::getAccessToken( Sentry::getUser() ),
                $params['engineCode'],
                $params['licensePlate'],
                $params['licenseType']
            );
        }
        catch( \Exception $e ){

            return Response::json([ 'errCode' => $e->getCode(), 'message' => $e->getMessage() ]);
        }

        return Response::json([ 'errCode' => 0, 'violations' => $car_result ]);
    }
}
