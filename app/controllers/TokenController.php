<?php

class TokenController extends BaseController{
    
    /**
     * 从远程服务器获取access token
     *
     * @return string
     */
    public static function getAccessTokenFromRemote( $appkey, $secretkey ){

        // http 请求
        try{

            $http_client = static::getBaseHttpClient();
            $response = $http_client->request( 'POST', '/token', [
                'query' => [
                    'appkey'    => $appkey,
                    'secretkey' => $secretkey
                ]
            ]);

            $response_content = json_decode( $response->getBody() );

            if ( static::isResponseSuccessful( $response_content ) ){
                return $response_content[ 'token' ];
            }

            // 服务器提供错误信息
            if ( array_key_exists( 'errMsg', $response_content ) ){

                $error_message = $response_content[ 'errMsg' ];
            }else{
                $error_message = '查询失败';
            }

            throw new SearchException( $error_message, $response_content['errCode'] );

        }
        // 请求失败
        catch( GuzzleException $e ){

            throw new Exception( "请求失败", 41 );
        }
        // 查询出错
        catch( SearchException $e ){

            throw $e;
        }
        // 其他错误
        catch( Exception $e ){

            throw new Exception( '服务器出错', 51 );
        }

        return null;
    }

    /**
     * 从缓存获取access token
     *
     * @return string
     */
    public static function getAccessTokenFromCache( $user_id = null ){

        // 不存在默认返回空字符串( 即长度为0字符串 )
        if ( $user_id == null ){

            return Cache::get( 'token', '' );
        }else{

            return Cache::get( "token_$user_id", '' );
        }
    }

    /**
     * 保存access token
     */
    public static function putAccessToken( $token, $user_id = null ){

        if ( $user_id == null ){

            Cache::put( 'token', $token );
        }else{

            Cache::put( "token_$user_id", $token );
        }
    }

    /**
     * 获得access token
     *
     * @return string
     */
    public static function getAccessToken( $user = null ){

        /*
            未设置$user，默认为普通用户
            token均从缓存中获取
            对于普通用户，token获取的key为：token
            对于企业用户，token获取的key为：'token_' + user_id，比如 'token_yhxx1231231231231231231231'
         */
        if ( $user == null || $user->is_common_user() ){

            // 从本地缓存中获取token
            $token = static::getAccessTokenFromCache();

            // 从缓存中获取失败，则从远程服务器获取
            if ( empty( $token ) ){

                $cheshang_config = Config::get( 'cheshang' );

                // 从远程服务器获取
                $token = static::getAccessTokenFromRemote( $cheshang_config['app_key'], $cheshang_config['secret_key'] );

                // 保存到缓存中并设置过期时间
                static::putAccessToken( $token );
            }

            return $token;

        // 企业用户
        }else if( $user->is_business_user() ){

            // 从本地缓存中获取token
            $token = static::getAccessTokenFromCache( $user->user_id );

            // 从缓存中获取失败，则从远程服务器中获取
            if ( empty( $token ) ){

                // 获取企业用户信息
                $user_bussiness_info = BussinessUser::find( $user->user_id );

                // 从远程服务器获取
                $token = static::getAccessTokenFromRemote( $user_bussiness_info->app_key, $user_bussiness_info->app_secret );

                static::putAccessToken( $token, $user_id );
            }

            return $token;
        }

        return null;
    }
}