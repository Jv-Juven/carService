<?php

class TokenController extends BaseController{
    
    /**
     * 从远程服务器获取access token
     *
     * @return string
     */
    public static function getAccessTokenFromRemote( $appkey, $secretkey ){

        return BusinessController::send_request([
            'method'    => 'POST',
            'uri'       => '/token',
            'query'     => [
                'appkey'    => $appkey,
                'secretkey' => $secretkey
            ]
        ], 'token' );
    }

    /**
     * 从缓存获取access token
     *
     * @return string
     */
    public static function getAccessTokenFromCache( $user_id = null ){

        // 不存在默认返回空字符串( 即长度为0字符串 )
        if ( $user_id == null ){

            return Cache::get( 'cheshang_token', '' );
        }else{

            return Cache::get( "token_user_$user_id", '' );
        }
    }

    /**
     * 保存access token
     */
    public static function putAccessTokenIntoCache( $token, $user_id = null ){

        if ( $user_id == null ){

            Cache::put( 'cheshang_token', $token );
        }else{

            Cache::put( "cheshang_token_user_$user_id", $token );
        }
    }

    /**
     * 获得access token
     *
     * @return string
     */
    public static function getAccessToken( $user = null ){

        /*
            未设置$user，默认为普通用户，
            token均从缓存中获取, 从缓存中获取失败，则从远程服务器中获取
            对于普通用户，app_key和app_secret用通用的, token获取的key为：token
            对于企业用户，app_key和app_secret每个用户均不相同, token获取的key为：'token_' + user_id，比如 'token_yhxx1231231231231231231231'
         */
        if ( $user == null || $user->is_common_user() ){

            // 从本地缓存中获取token
            $token = static::getAccessTokenFromCache();

            // 从缓存中获取失败，则从远程服务器获取
            if ( empty( $token ) ){

                $cheshang_config = Config::get( 'domain' );

                // 从远程服务器获取
                $token = static::getAccessTokenFromRemote( $cheshang_config['app_key'], $cheshang_config['app_secret'] );

                // 保存到缓存中并设置过期时间
                static::putAccessTokenIntoCache( $token );
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

                static::putAccessTokenIntoCache( $token, $user_id );
            }

            return $token;
        }

        return null;
    }
}