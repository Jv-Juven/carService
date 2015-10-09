<?php

use GuzzleHttp\Client as httpClient;
use GuzzleHttp\Exception\ClientException as ClientException;

class BusinessController extends BaseController{

	protected static function getBaseHttpClient(){

		return new httpClient([
			'base_uri' 	=> Config::get( 'domain.server' ),
		]);
	}

	protected static function isResponseSuccessful( $response ){

		return array_key_exists( 'errCode', $response ) && $response['errCode'] == 0;
	}

	protected static function logError( $user_id, $action, $error_message ){

		Log::info( "User: $user_id\n"."Action: $action\n"."Error message: $error_message" );
	}

	/**
	 * 获得用户app key，若未指定$user_id，则取当前用户
	 * 
	 * @param 	$user_id 	string
	 * @return 	string
	 */
	public static function get_appkey( $user_id = null ){

		if ( $user_id ){
			$business_user = BusinessUser::find( $user_id );
		}else{
			$business_user = BusinessUser::find( Sentry::getUser()->user_id );
		}

		if ( !isset( $business_user ) ){
			throw new Exception( '非企业用户', 31 );
		}

		return $business_user->app_key;
	}

	/**
	 * 算服务费
	 *
	 * @param 	$user_id 	string
	 * @return 	float
	 */
	public static function getServiceFee( $user_id = null ){

		if ( $user_id ){
			$user = User::find( $user_id );
		}else{
			$user = Sentry::getUser();
		}

		$fee_type 	= FeeType::where( 'user_type', $user->user_type )
							 ->where( 'category', FeeType::get_service_code() )
							 ->where( 'item', FeeType::get_service_subitem( $user->user_type ) )
							 ->first();
		$user_fee 	= UserFee::where( 'fee_type_id', $fee_type->id )->first();

		// 有特殊费用情况
		if ( isset( $user_fee ) && $user_fee->fee_no != null ){
			return $user_fee->fee_no;
		}

		// 否则返回默认值
		return $fee_type->number;
	}

	/**
	 * 算快递费
	 *
	 * @param 	$user_id 	string
	 * @return 	float
	 */
	public static function getExpressFee( $user_id = null ){

		if ( $user_id ){
			$user = User::find( $user_id );
		}else{
			$user = Sentry::getUser();
		}

		$fee_type 	= FeeType::where( 'user_type', $user->user_type )
							 ->where( 'category', FeeType::get_express_code() )
							 ->where( 'item', FeeType::get_express_subitem( $user->user_type ) )
							 ->first();
		$user_fee 	= UserFee::where( 'fee_type_id', $fee_type->id )->first();

		// 有特殊费用情况
		if ( isset( $user_fee ) && $user_fee->fee_no != null ){
			return $user_fee->fee_no;
		}

		// 否则返回默认值
		return $fee_type->number;
	}

	/**
	 * 通用请求函数
	 *
	 * @param 	$http_params 	array 	[ 'method' => 'GET', 'uri' => '/xx/xx', 'query' => [ ... ] ]
	 * @return 	mixed
	 */
	public static function send_request( $http_params, $return_flieds = null ){

		try{
			$http_client = static::getBaseHttpClient();

			$method = strtoupper( $http_params['method'] );

			if( $method == 'GET' ) {

				$query_params = [ 'query' => $http_params['query'] ];
			}
			else if ( $method == 'POST' ){

				$query_params = [ 'form_params' => $http_params['query'] ];
			}

			$response = $http_client->request( $method, $http_params['uri'], $query_params );

			$response_content = $response->getBody()->getContents();

			// 默认解析为json
			if ( !array_key_exists('accept', $http_params) || $http_params['accept'] == 'json' ){
				$response_content = json_decode( $response_content, true );
			}
			// 其他格式直接返回
			else{
				return $response_content;
			}

			// 处理成功，即 errCode == 0
			if ( static::isResponseSuccessful( $response_content ) ){

				// 未指定成功时的需取得的值
				if ( empty( $return_flieds ) ){
					return $response_content;
				}

				/* 
				 * 指定则使用laravel自带的array_get函数取值
				 * 使用 array_get( $array, 'data.info.name' ) ...
				 * 参考http://www.golaravel.com/laravel/docs/4.2/helpers/#arrays
				 */
				else{
					return array_get( $response_content, $return_flieds );
				}	
			}

			// 若服务器提供错误信息，则返回相应消息，否则统一返回'操作失败'
			if ( array_key_exists( 'errMsg', $response_content ) ){
				$error_message = $response_content[ 'errMsg' ];
			}
			else{
				$error_message = '操作失败';
			}

			throw new OperationException( $error_message, $response_content['errCode'] );
		}
		catch( ClientException $e ){

			throw $e;
			throw new Exception( "请求失败", 41 );
		}
		// 查询出错
		catch( OperationException $e ){

			throw $e;
		}
		// 其他错误
		catch( Exception $e ){

			throw $e;
			throw new Exception( '服务器出错', 51 );
		}

		// Return null in case the server has been fucked
		return null;
	}

	/**
	 * 根据$user_id从远程服务器获取app key和app secret
	 * 
	 * @param 	$user_id 	string
	 * @return 	array
	 * @example [ 'uid': 'xxx', 'appkey': 'xxxx', secretKey: '' ]
	 */
	public static function get_appkey_appsecret_from_remote( $user_id ){

		$http_params = [
			'method'	=> 'GET',
			'uri'		=> '/app',
			'query'		=> [
				'uid'	=> $user_id,
				'token'	=> static::create_request_token()
			]
		];

		return static::send_request( $http_params, 'app' );
	}

	/**
	 * 查询企业用户业务默认单价
	 *
	 * 管理人员接口，原样返回计费系统的返回结果
	 *
	 * @return 	array
	 */
	public static function get_default_univalence( ){

		$http_params = [
			'method'	=> 'GET',
			'uri'		=> '/account/default-univalence',
			'query'		=> [
				'token'	=> static::create_request_token()
			]
		];

		return static::send_request( $http_params, 'data' );
	}

	/**
	 * 修改企业查询业务默认单价
	 *
	 * 管理人员接口，原样返回计费系统的返回结果
	 *
	 * @param 	$query 	array 	[ 'violation' => 0.2, 'license' => 0.2, 'car' => 0.6 ]
	 * @return 	array
	 */
	public static function modify_default_univalence( $query ){
		$token = static::create_request_token();

		$http_params = [
			'method'	=> 'POST',
			'uri'		=> '/account/default-univalence',
			'query'		=> [
				'params'	=> $query,
				'token'		=> $token
			]
		];

		return static::send_request( $http_params, 'data' );
	}

	/**
	 * 修改特定企业查询业务单价
	 *
	 * 管理人员接口，原样返回计费系统的返回结果
	 *
	 * @param 	$query 	array 	[ 'violation' => 0.2, 'license' => 0.2, 'car' => 0.6 ]
	 * @return 	array
	 */
	public static function modify_business_user_univalence( $user_id, $query ){

		$query[ 'token' ] = static::create_request_token();
		$query[ 'appkey' ] = static::get_appkey( $user_id );

		$http_params = [
			'method'	=> 'POST',
			'uri'		=> '/account/univalence',
			'query'		=> $query
		];

		return static::send_request( $http_params, 'account' );
	}

	/**
	 * 充值
	 *
	 * 仅对企业用户开放
	 *
	 * @param 	$number 	integer 	0.00
	 * @param 	$user_id 	string
	 * @return 	boolean
	 */
	public static function recharge( $number, $user_id = null ){

		$http_params = [
			'method'	=> 'POST',
			'uri'		=> '/account/recharge',
			'query'		=> [
				'money'		=> $number,
				'appkey'	=> static::get_appkey( $user_id ),
				'token'		=> static::create_request_token()
			]
		];

		return static::send_request( $http_params, 'errCode' ) == 0;
	}

	/**
	 * 获取访问次数信息
	 *
	 * 仅对企业用户开放
	 *
	 * @param 	$user_id 	string
	 * @return 	array
	 */
	public static function count( $user_id = null ){

		$http_params = [
			'method'	=> 'GET',
			'uri'		=> '/account/count',
			'query'		=> [
				'appkey'	=> static::get_appkey( $user_id ),
				'token'		=> static::create_request_token()
			]
		];

		return static::send_request( $http_params, 'data' );
	}

	/**
	 * 获取账户信息
	 *
	 * @param 	$user_id 	string
	 * @return 	array
	 */
	public static function accountInfo( $user_id = null ){

		$http_params = [
			'method'	=> 'GET',
			'uri'		=> '/account',
			'query'		=> [
				'appkey'	=> static::get_appkey( $user_id ),
				'token'		=> static::create_request_token()
			]
		];

		return static::send_request( $http_params, 'account' );
	}

	/**
	 * 查询违章信息
	 *
	 * @param 	$token 			string
	 * @param 	$engineCode 	string
	 * @param 	$licensePlate 	string
	 * @param 	$licenseType 	string
	 * @return 	array
	 */
	public static function violation( $token, $engineCode, $licensePlate, $licenseType ){

		$http_params = [
			'method'	=> 'GET',
			'uri'		=> '/api/violation',
			'query'		=> [
				'token'			=> $token,
				'engineCode'	=> $engineCode,
				'licenseType'	=> $licenseType,
				'licensePlate'	=> $licensePlate
			]
		];

		$search_result = json_decode( static::send_request( $http_params, 'data' ), true );
		$search_result['returnCode'] = (int)( $search_result['returnCode'] );

		if ( (int)( $search_result['returnCode'] ) == 1 ){

			foreach ( $search_result[ 'body' ] as $key => $value ){

				if ( isset( $value[ 'tips' ] ) ){

					throw new SearchException( '查询失败', 32 );
				}
			}

			return $search_result[ 'body' ];

		}else{

			throw new SearchException( '查询失败', 32 );
		}
	}

	/**
	 * 查询驾驶证扣分信息
	 *
	 * @param 	$token 			string
	 * @param 	$record_id 		string
	 * @param 	$identity_id 	string
	 * @return 	array
	 */
	public static function license( $token, $identity_id, $record_id ){

		$http_params = [
			'method'	=> 'GET',
			'uri'		=> '/api/license',
			'query'		=> [
				'token'			=> $token,
				'recordID'		=> $record_id,
				'identityID'	=> $identity_id
			]
		];

		return static::send_request( $http_params );

		$search_result = json_decode( static::send_request( $http_params, 'data' ), true );
		$search_result['returnCode'] = (int)( $search_result['returnCode'] );

		if ( (int)( $search_result['returnCode'] ) == 1 ){

			return $search_result[ 'body' ];

		}else{

			throw new SearchException( '查询失败', 32 );
		}
	}

	/**
	 * 查询车辆信息
	 *
	 * @param 	$token 			string
	 * @param 	$engineCode 	string
	 * @param 	$licensePlate 	string
	 * @param 	$licenseType 	string
	 * @return 	array
	 */
	public static function car( $token, $engineCode, $licensePlate, $licenseType ){

		$http_params = [
			'method'	=> 'GET',
			'uri'		=> '/api/car',
			'query'		=> [
				'token'			=> $token,
				'engineCode'	=> $engineCode,
				'licenseType'	=> $licenseType,
				'licensePlate'	=> $licensePlate
			]
		];

		return json_decode( static::send_request( $http_params, 'data' ), true );
	}

	/**
	 * 生成随机的验证请求的token
	 *
	 * @return 	string
	 */
	public static function create_request_token( $prefix = 'rt' ){

		$token = str_replace( '.', '', uniqid( 'rt', true ) );

		Cache::put( $token, $token, 120 );

		return $token;
	}

	/**
	 * 验证请求的token
	 *
	 * @return 	array
	 */
	public static function auth_request_token(){

		$token = Input::get( 'token' );

		if ( Cache::has( $token ) ){
			
			Cache::forget( $token );

			return Response::json([ 'errCode' => 0 ]);
		}

		return Response::json([ 'errCode' => 1 ]);
	}
}