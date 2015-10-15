<?php

class SearchController extends BaseController{

    protected static function process_error( $error_code, $error_message ){

        if ( $error_code == 0 ){
            $error_code = -1;
        }

        return [ 'errCode' => $error_code, 'message' => $error_message ];
    }

    protected static $search_limit = 2;

    // 过期时间
    protected static function __get_expired(){

        return ( Carbon\Carbon::tomorrow()->timestamp - time() ) / 60;
    }

    // 获取缓存中的key
    protected static function __get_count_cache_key( $user_id, $action ){

        return $user_id.'_'.$action.'_count';
    }

    // 获取查询次数
    protected static function __get_search_count( $user_id, $action ){

        return (int)Cache::get( static::__get_count_cache_key( $user_id, $action ) );
    }

    // 设置查询次数
    protected static function __set_search_count( $user_id, $action, $count ){

        Cache::put( static::__get_count_cache_key( $user_id, $action ), $count, static::__get_expired() );
    }

    // 查询次数加1
    protected static function __inc_search_count( $user_id, $action ){

        $count = static::__get_search_count( $user_id, $action );

        static::__set_search_count( $user_id, $action, $count + 1 );
    }

    // 获得访问限制次数
    public static function get_search_limit(){

        return static::$search_limit;
    }

    // 获取访问次数
    public static function get_serach_count( $user_id, $action = 'violation' ){

        return static::__get_search_count( $user_id, $action );
    }

    // 获取剩余访问次数
    public static function get_search_count_remain( $user_id, $action = 'violation' ){

        return static::$search_limit - static::get_serach_count( $user_id, $action );
    }

    // 是否达到访问限制
    public static function is_reach_search_limit( $user_id, $action = 'violation' ){

        return static::__get_search_count( $user_id, $action ) >= static::$search_limit;
    }

    // 访问次数加1
    public static function increase_search_count( $user_id, $action = 'violation' ){

        static::__inc_search_count( $user_id, $action );
    }
    
    public function violation(){

        if ( !Sentry::check() ){

            return Response::json([ 'errCode' => 10, 'message' => '请登录' ]);
        }

        //$current_user = User::find( Sentry::getUser()->user_id );

        $current_user = Sentry::getUser();

        if ( $current_user->is_common_user() && static::is_reach_search_limit( $current_user->user_id, 'violation' ) ){
            return Response::json([ 'errCode' => 2, 'message' => '您已经达到查询上限。每日可查询2次' ]);
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

        $attributes = [
            'engineCode'        => '发动机号',
            'licensePlate'      => '车牌号码',
            'licenseType'       => '车辆类型'
        ];

        $validator = Validator::make( $params, $rules, $messages, $attributes );

        // 格式不对，将返回第一个错误
        if ( $validator->fails() ){

           return Response::json([ 'errCode' => 1, 'message' => $validator->messages()->first() ]); 
        }
        
        try{
            // 请求数据
            $search_result = BusinessController::violation(
                TokenController::getAccessToken( $current_user ),
                $params['engineCode'],
                $params['licensePlate'],
                $params['licenseType']
            );

            $account = [
                'unit'      => $search_result['account']['violationUnit'],
                'balance'   => $search_result['account']['balance']
            ];

            // 解析请求
            $result_to_keep = [];
            $result_to_show = [];
            $search_result['data']['returnCode'] = (int)($search_result['data']['returnCode']);

            if ( $search_result['data']['returnCode'] == 1 ){
                
                foreach ( $search_result['data']['body'] as $value ){

                    // 过滤错误
                    if ( isset( $value[ 'tips' ] ) ){

                        throw new OperationException( '查询失败', 32 );
                    }

                    // 只显示未处理的违章信息
                    if ( $value['clbj'] != '1' ){

                        array_push( $result_to_show, $value );

                        // 未处理且违法记分为0的，则可以处理
                        if ( $value['wfjfs'] == '0' ){

                            array_push( $result_to_keep, $value );
                        }
                    }
                }
            }
            else{

                throw new OperationException( '查询失败', 32 );
            }

            // 违章信息存到session，以便下单
            // 没有违章记录则不保存
            if ( count( $result_to_keep ) ){

                // 取出序号
                $violations_xh = array_map(function( $r ){

                    return $r['xh'];

                }, $result_to_keep);

                // 重新拼接，序号作为键，违章信息作为值
                $result_to_keep = array_combine( $violations_xh, $result_to_keep );

                $service_fee = BusinessController::getServiceFee();
                $express_fee = BusinessController::getExpressFee();

                $info = [
                    'car_type_no'       => $params['licenseType'],
                    'car_plate_no'      => $params['licensePlate'],
                    'car_engine_no'     => $params['engineCode'],
                ];

                // 以此方式计算一次查询的sign
                $sign = md5( http_build_query( $info ) );

                // 如果Session中存在已查询过的数据，取Session中数据
                if ( Session::has( 'violations' ) ){

                    $violations = Session::get( 'violations' );
                }
                else{

                    $violations = [];
                }

                // 判断是否存在该次查询的数据
                if ( array_key_exists( $sign, $violations ) ){

                        // 判断状态码
                    if ( $violations[ $sign ][ 'info' ][ 'status' ] == AgencyController::$AGENCY_STATUS_CONFIRMED ){
                        return Response::json([ 'errCode' => 3, 'message' => '您已确认办理该车辆违章信息，请到提交订单页面确认或取消后再查询', 'sign' => $sign ]);
                    }

                    $service_fee = array_get( $violations, $sign.'.info.service_fee' );
                         
                        // 过滤已经存在的违章信息
                    $violations[ $sign ][ 'results' ] = array_replace (  $violations[ $sign ][ 'results' ], $result_to_keep );
                }
                // 不存在直接存储到Session
                else{
                    $info['service_fee'] = $service_fee;
                    $info['express_fee'] = $express_fee;
                    $info['status']      = AgencyController::$AGENCY_STATUS_SEARCHED;

                    $violations[ $sign ] = [
                        'info'      => $info,
                        'results'   => $result_to_keep
                    ];
                }

                Session::put( 'violations', $violations );
            }
        }
        catch( OperationException $e ){

            $return_message = static::process_error( $e->getCode(), $e->getMessage() );

            $return_message['user_type'] = $current_user->user_type;

            // 普通用户返回剩余查询次数
            if ( $current_user->is_common_user() && $e->getCode() < 50 ){

                static::increase_search_count( $current_user->user_id );

                $return_message['remain_search_count'] =  static::get_search_count_remain( $current_user->user_id );
            }
            // 企业用户返回账户信息
            else if ( $current_user->is_business_user() && isset( $account ) ){

                $return_message['account'] = $account;
            }

            return Response::json( $return_message );
        }
        catch( \Exception $e ){

            return Response::json( static::process_error( $e->getCode(), $e->getMessage() ) );
        }

        $return_message = [ 'errCode' => 0, 'violations' => $result_to_show ];

        // 普通用户返回剩余查询次数
        if ( $current_user->is_common_user() ){

            static::increase_search_count( $current_user->user_id );

            $return_message['remain_search_count'] =  static::get_search_count_remain( $current_user->user_id );
        }
        // 企业用户返回账户信息
        else if ( $current_user->is_business_user() ){

            $return_message['account'] = $account;
        }

        $return_message['user_type'] = $current_user->user_type;

        if ( isset( $sign ) ){
            $return_message[ 'sign' ] = $sign;
        }

        if ( isset( $service_fee ) ){
            $return_message[ 'service_fee' ] = $service_fee;
        }

        return Response::json( $return_message );
    }

    public function license(){

        if ( Sentry::getUser()->is_common_user() ){
            return Response::json([ 'errCode' => 2, '无权限' ]);
        }

        $params = Input::all();

        $rules = [
            'identityID'        => 'required|id_card',
            'recordID'          => 'required'
        ];

        $messages = [
            'required'          => '请输入:attribute',
            'id_card'           => ':attribute格式不正确'
        ];

        $attributes = [
            'identityID'        => '身份证号',
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
                $params['identityID'],
                $params['recordID']
            );

            $account = [
                'unit'      => $search_result['account']['licenseUnit'],
                'balance'   => $search_result['account']['balance']
            ];

            if ( (int)$search_result['data']['returnCode'] != 1 ){
                
                throw new OperationException( '查询失败', 32 );
            }
        }
        catch( OperationException $e ){

            $message = static::process_error( $e->getCode(), $e->getMessage() );

            if ( $e->getCode() < 50 & isset( $account ) ){
                $message['account'] = $account;
            }

            return Response::json( $message );       
        }
        catch( \Exception $e ){

            return Response::json( static::process_error( $e->getCode(), $e->getMessage() ) );
        }

        return Response::json([ 'errCode' => 0, 'number' => $search_result['data']['body']['ljjf'], 'account' => $account ]);
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

        $attributes = [
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

            $account = [
                'unit'      => $search_result['account']['carUnit'],
                'balance'   => $search_result['account']['balance']
            ];

            if ( $search_result['data']['returnCode'] != 1 ){

                throw new OperationException( '查询失败', 32 );
            }
        }
        catch( OperationException $e ){

            $message = static::process_error( $e->getCode(), $e->getMessage() );

            if ( $e->getCode() < 50 & isset( $account ) ){
                $message['account'] = $account;
            }

            return Response::json( $message );  
        }
        catch( \Exception $e ){

            return Response::json( static::process_error( $e->getCode(), $e->getMessage() ) );
        }

        return Response::json([ 'errCode' => 0, 'car' => $search_result['data']['body'][0], 'account' => $account ]);
    }
}
