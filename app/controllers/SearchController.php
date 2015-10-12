<?php

class SearchController extends BaseController{

    protected static function process_error( $error_code, $error_message ){

        if ( $error_code == 0 ){
            $error_code = -1;
        }

        return [ 'errCode' => $error_code, 'message' => $error_message ];
    }
    
    public function violation(){

        $current_user = Sentry::getUser();

/*
        if ( $current_user->is_common_user() && static::is_reach_search_limit( $current_user, 'violation' ) ){
            return Response::json([ 'errCode' => 2, '您已经达到查询上限。每日可查询2次' ]);
        }
*/
        $params = Input::all();

        $rules = [
            'req_car_engine_no' => 'required|size:6',
            'req_car_plate_no'  => 'required|size:7',
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

        // 格式不对，将返回第一个错误
        if ( $validator->fails() ){

           return Response::json([ 'errCode' => 1, 'message' => $validator->messages()->first() ]); 
        }
        
        try{
            // 请求数据
            $search_result = BusinessController::violation(
                TokenController::getAccessToken( Sentry::getUser() ),
                $params['req_car_engine_no'],
                $params['req_car_plate_no'],
                $params['car_type_no']
            );

            // 解析请求
            $search_result['returnCode'] = (int)($search_result['returnCode']);

            if ( $search_result['returnCode'] == 1 ){

                // 过滤错误以及处理标志为1的违章信息
                foreach ( $search_result[ 'body' ] as $key => $value ){

                    if ( isset( $value[ 'tips' ] ) ){

                        throw new SearchException( '查询失败', 32 );
                    }

                    if ( array_key_exists( 'jkbj', $value ) && (int)($value['jkbj']) == 1 ){

//                        unset( $search_result['body'][$key] );
                    }
                }
            }
            else{

                throw new SearchException( '查询失败', 32 );
            }

            // 违章信息存到session，以便下单
            // 没有违章记录则不保存
            if ( count( $search_result['body'] ) ){

                // 取出序号
                $violations_xh = array_map(function( $r ){

                    return $r['xh'];

                }, $search_result['body']);

                // 重新拼接，序号作为键，违章信息作为值
                $current_result = array_combine( $violations_xh, $search_result['body'] );

                $service_fee = BusinessController::getServiceFee();
                $express_fee = BusinessController::getExpressFee();

                $info = [
                    'car_type_no'       => $params['car_type_no'],
                    'car_plate_no'      => $params['req_car_plate_no'],
                    'car_engine_no'     => $params['req_car_engine_no'],
                ];

                // 以此方式计算一次查询的sign
                $sign = md5( http_build_query( $info ) );

                // 如果Session中存在已查询过的数据，取Session中数据
                if ( Session::has( 'violations' ) ){

                    $violations = Session::get( 'violations' );

                    // 判断Session中是否存在该次查询的数据
                    if ( array_key_exists( $sign, $violations ) ){

                        // 判断状态码
                        if ( $violations[ $sign ][ 'info' ][ 'status' ] == AgencyController::$AGENCY_STATUS_SEARCHED ){
                            return Response::json([ 'errCode' => 2, 'message' => '您已确认办理', 'sign' => $sign ]);
                        }

                        $service_fee = array_get( $violations, $sign.'.info.service_fee' );
                         
                        // 过滤已经存在的违章信息
                        $violations[ $sign ][ 'results' ] = array_replace (  $violations[ $sign ][ 'results' ], $current_result );
                    }
                    // 不存在直接存储到Session
                    else{
                        $info['service_fee'] = $service_fee;
                        $info['express_fee'] = $express_fee;
                        $info['status']      = AgencyController::$AGENCY_STATUS_SEARCHED;

                        $violations[ $sign ] = [
                            'info'      => $info,
                            'results'   => $current_result
                        ];
                    }
                    
                    Session::put( 'violations', $violations );
                }
                // Session不存在已查询过的数据
                else{

                    $info['service_fee'] = $service_fee;
                    $info['express_fee'] = $express_fee;
                    $info['status']      = AgencyController::$AGENCY_STATUS_SEARCHED;

                    Session::put( 'violations', [
                        $sign    => [
                            'info'      => $info,
                            'results'   => $current_result
                        ]
                    ]);
                }
            }
        }
        catch( \Exception $e ){

            throw $e;

            return Response::json( static::process_error( $e->getCode(), $e->getMessage() ) );
        }

        return Response::json([ 'errCode' => 0, 'violations' => $search_result['body'], 'sign' => $sign, 'service_fee' => $service_fee ]);
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

        // 格式不对，将返回第一个错误
        if ( $validator->fails() ){

           return Response::json([ 'errCode' => 1, 'message' => $validator->messages()->first() ]); 
        }

        try{
            $search_result = BusinessController::license(
                TokenController::getAccessToken( Sentry::getUser() ),
                $params['identityId'],
                $params['recordID']
            );

            if ( $search_result['returnCode'] != 1 ){
                
                throw new SearchException( '查询失败', 32 );
            }
        }
        catch( \Exception $e ){

            throw $e;

            return Response::json( static::process_error( $e->getCode(), $e->getMessage() ) );
        }

        return Response::json([ 'errCode' => 0, 'violations' => $search_result['body'] ]);
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

        // 格式不对，将返回第一个错误
        if ( $validator->fails() ){

           return Response::json([ 'errCode' => 1, 'message' => $validator->messages()->first() ]); 
        }

        try{
            $search_result = BusinessController::car(
                TokenController::getAccessToken( Sentry::getUser() ),
                $params['engineCode'],
                $params['licensePlate'],
                $params['licenseType']
            );

            if ( $search_result['returnCode'] != 1 ){

                throw new SearchException( '查询失败', 32 );
            }
        }
        catch( \Exception $e ){

            throw $e;

            return Response::json( static::process_error( $e->getCode(), $e->getMessage() ) );
        }

        return Response::json([ 'errCode' => 0, 'violations' => $search_result['body'] ]);
    }
}
