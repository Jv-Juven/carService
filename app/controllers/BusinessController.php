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

			// $error_message = '操作失败';

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
     * @param   $token          string
     * @param   $engineCode     string
     * @param   $licensePlate   string
     * @param   $licenseType    string
     * @return  array
     */
    public static function violation( $token, $engineCode, $licensePlate, $licenseType ){

        $http_params = [
            'method'    => 'GET',
            'uri'       => '/api/violation',
            'query'     => [
                'token'         => $token,
                'engineCode'    => $engineCode,
                'licenseType'   => $licenseType,
                'licensePlate'  => $licensePlate
            ]
        ];

        $search_result =  static::send_request( $http_params );

        $search_result['data'] = json_decode( $search_result['data'], true );

        return [ 'data' => $search_result['data'], 'account' => $search_result['account'] ];

        $account = $search_result['account'];

        $search_result = '{"returnCode":"1","returnMessage":"查询成功","time":"20151011103817","body":[{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406050002584380","wfsj":"2011-01-12 09:23:00","wfbh":"4406142013141909883451","wfdz":"金源路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队二中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406050002414253","wfsj":"2010-10-14 20:29:00","wfbh":"4406142013141909883391","wfdz":"永安路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队一中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406050002763468","wfsj":"2011-03-07 09:51:00","wfbh":"4406142013141909883381","wfdz":"金源路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队二中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406050002945395","wfsj":"2011-04-28 10:38:00","wfbh":"4406142013141909883501","wfdz":"魁奇一路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队二中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406987900713888","wfsj":"2014-04-24 17:36:00","wfbh":"4406982015181905416861","wfdz":"佛山一环路41公里460米（南线东往西）","wfxw":"1352A","fkje":"150","cljgmc":"佛山市公安局交通警察支队一环公路大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速10%未达20%的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406050002996599","wfsj":"2011-05-17 18:06:00","wfbh":"4406042012141902996281","wfdz":"季华路","wfxw":"1019","fkje":"150","cljgmc":"佛山禅城交警一大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定使用专用车道的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4419177900081995","wfsj":"2011-08-18 17:58:00","wfbh":"4419202012101900584441","wfdz":"东莞市常平镇新城大道东莞市常平镇新城路土塘路段","wfxw":"1303","fkje":"150","cljgmc":"东莞市交警支队南城大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车行驶超过规定时速50%以下的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406147902465696","wfsj":"2014-11-20 08:30:00","wfbh":"4406142015141924633491","wfdz":"佛山大道","wfxw":"1345","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队三中队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车违反禁止标线指示的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406047900314434","wfsj":"2011-10-27 09:01:00","wfbh":"4406042012141902996211","wfdz":"佛山大道","wfxw":"1303","fkje":"150","cljgmc":"佛山禅城交警一大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车行驶超过规定时速50%以下的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406987900034183","wfsj":"2011-10-31 08:38:00","wfbh":"4406002012101800196671","wfdz":"佛山一环路段南线K42+575大罗入口路段","wfxw":"4305","fkje":"200","cljgmc":"新佛山交警支队交管科","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"在高速公路上超速不足50%的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4407847900401034","wfsj":"2013-07-13 19:05:00","wfbh":"4407842013141903308121","wfdz":"325国道39公里350米","wfxw":"7012","fkje":"200","cljgmc":"鹤山市公安局交通警察大队一中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车驾驶人在乘坐人员未按规定使用安全带的情况下驾驶机动车的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406147902039921","wfsj":"2014-07-15 15:45:00","wfbh":"4406142015141924633541","wfdz":"普澜二路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队机动中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4490027900971235","wfsj":"2014-12-12 16:05:26","wfbh":"4490022015121909149211","wfdz":"325国道1公里","wfxw":"1018","fkje":"150","cljgmc":"佛山市公安局南海分局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车不在机动车道内行驶的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4490017900095437","wfsj":"2011-10-08 22:17:20","wfbh":"4490012013111009411621","wfdz":"顺德区大良东康路南国中路口","wfxw":"1344","fkje":"200","cljgmc":"佛山市顺德区公安局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车违反禁令标志指示的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4490017901667847","wfsj":"2014-04-20 14:44:08","wfbh":"4490012015111019828871","wfdz":"佛山市东平新城天虹路（乐从路段）","wfxw":"1039","fkje":"200","cljgmc":"佛山市顺德区公安局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4490027900778034","wfsj":"2014-10-09 11:25:01","wfbh":"4490022015121909149201","wfdz":"儒林西路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局南海分局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4490027900103541","wfsj":"2013-11-17 19:30:00","wfbh":"4490022014121902683691","wfdz":"桂城城区路段","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局南海分局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4490027900706875","wfsj":"2014-09-05 16:04:06","wfbh":"4490022015121909149191","wfdz":"325国道1公里","wfxw":"1018","fkje":"150","cljgmc":"佛山市公安局南海分局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车不在机动车道内行驶的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4401104317645900","wfsj":"2012-08-10 00:41:59","wfbh":"4401132013131539776721","wfdz":"龙溪大道蟠龙村路段","wfxw":"4305","fkje":"200","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"在高速公路上超速不足50%的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406280001672942","wfsj":"2011-02-01 08:28:54","wfbh":"4490012013111009411591","wfdz":"325国道26KM+200M(顺德区龙江大坝桥脚路段)1","wfxw":"1303","fkje":"150","cljgmc":"佛山市顺德区公安局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车行驶超过规定时速50%以下的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4407020005219569","wfsj":"2011-02-15 18:55:16","wfbh":"4407032013131902054391","wfdz":"江门市蓬江区滨江大道","wfxw":"7012","fkje":"200","cljgmc":"江门市公安交通管理局蓬江交通警察大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车驾驶人在乘坐人员未按规定使用安全带的情况下驾驶机动车的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406987900642868","wfsj":"2014-01-26 16:09:00","wfbh":"4406982014181903092421","wfdz":"佛山一环路41公里460米(南线东往西)","wfxw":"1352","fkje":"150","cljgmc":"佛山市公安局交通警察支队一环公路大队二中队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速未达20%的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406147900776683","wfsj":"2013-03-06 14:36:00","wfbh":"4406142013141909883431","wfdz":"同华横街","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队一中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4406147901448169","wfsj":"2013-10-25 10:35:00","wfbh":"4406142014141916006401","wfdz":"金源路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局禅城分局交通警察大队二中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤YU0921","hpzl":"02","fdjh":"339525","xh":"4490027901060511","wfsj":"2015-01-28 19:09:45","wfbh":"4490022015121909535611","wfdz":"桂澜路","wfxw":"1039","fkje":"200","cljgmc":"佛山市公安局南海分局交通警察大队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"}],"signInfo":"9184777F77A40D8B5D4DEDFB8AB1C99E","systemNo":"02","id":"IDCJDCWF151011110201","clientId":"1.0.0.2"}';

        $search_result = '{"returnCode":"1","returnMessage":"查询成功","time":"20151011175210","body":[{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4315200002645104","wfsj":"2014-06-10 12:12:00","wfbh":"4315142014141901138211","wfdz":"岳临高速530km+800m","wfxw":"1636","fkje":"150","cljgmc":"常吉大队交管科","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4304000000895536","wfsj":"2014-06-08 11:59:00","wfbh":"4304002014101904682661","wfdz":"衡阳市一环西路衡枣高速管理处至一环南路口路段","wfxw":"1352","fkje":"150","cljgmc":"湖南省衡阳市公安局交通警察支队交通安全宣传教育科","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4351077900045328","wfsj":"2015-04-23 20:43:00","wfbh":"4360042015141900080271","wfdz":"长潭西高速15KM+600M","wfxw":"1352","fkje":"150","cljgmc":"湖南省高速公路交通警察局郴州支队临武大队堡城警务站","clbj":"1","jkbj":"0","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4402907901503226","wfsj":"2015-07-05 14:16:38","wfbh":"4402902015101909715261","wfdz":"京港澳高速1951公里","wfxw":"1636","fkje":"150","cljgmc":"韶关市公安局交通警察支队高速公路一大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4402927900325371","wfsj":"2015-07-05 15:43:43","wfbh":"4402922015121800845001","wfdz":"广乐高速15公里","wfxw":"1636","fkje":"150","cljgmc":"韶关市公安局交通警察支队高速公路三大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137902238856","wfsj":"2015-07-05 12:58:28","wfbh":"4401132015131564682301","wfdz":"京港澳高速鳌头镇路段","wfxw":"1352A","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"0","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速10%未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4360017900024308","wfsj":"2015-07-05 16:40:00","wfbh":"4419362015161902888141","wfdz":"京港澳高速1757km+450m","wfxw":"1636","fkje":"150","cljgmc":"东莞市公安局交通警察支队东城大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4315180000374418","wfsj":"2014-06-08 11:18:20","wfbh":"4315142014141901138201","wfdz":"岳临高速公路0312公里000米","wfxw":"1636","fkje":"150","cljgmc":"常吉大队交管科","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401287900136799","wfsj":"2015-01-22 14:02:00","wfbh":"4401282015181504386451","wfdz":"香雪三路（人工拍摄）","wfxw":"1039","fkje":"200","cljgmc":"萝岗大队二中队","clbj":"1","jkbj":"1","wfjfs":"0","wfxwzt":"机动车违反规定停放、临时停车，妨碍其它车辆、行人通行的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4406967900627137","wfsj":"2015-03-18 10:17:00","wfbh":"4406962015161906004461","wfdz":"二广高速广州支线1002公里100米","wfxw":"1352A","fkje":"150","cljgmc":"佛山市公安局交通警察支队高速公路二大队二中队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速10%未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4315180000373535","wfsj":"2014-06-04 21:43:00","wfbh":"4315142014141901138191","wfdz":"岳临高速315km+500m","wfxw":"1352","fkje":"150","cljgmc":"常吉大队交管科","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4404997900199180","wfsj":"2014-06-19 14:44:00","wfbh":"4404992014191902240871","wfdz":"西部沿海高速25公里700米","wfxw":"1636","fkje":"150","cljgmc":"珠海市公安局交通警察支队高速公路大队一中队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4407007900320494","wfsj":"2014-07-15 07:55:00","wfbh":"4407002014101909467131","wfdz":"沈海高速K3141+300至K3143+700路段往开平方向","wfxw":"1345","fkje":"200","cljgmc":"江门市公安局交通警察支队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车违反禁止标线指示的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4406967900491929","wfsj":"2014-07-14 13:32:00","wfbh":"4406962014161903626411","wfdz":"广州绕城高速165公里300米","wfxw":"1636","fkje":"150","cljgmc":"佛山市公安局交通警察支队高速公路二大队一中队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4301880002337091","wfsj":"2015-04-13 17:43:13","wfbh":"4356012015111900141411","wfdz":"长沙市三一大道与车站路交叉路口","wfxw":"1345","fkje":"200","cljgmc":"道仁异地处罚室（中队）","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车违反禁止标线指示的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4301880002353531","wfsj":"2015-04-17 15:14:47","wfbh":"4356012015111900141421","wfdz":"长沙市韶山路与城南路交叉路口","wfxw":"1345","fkje":"200","cljgmc":"道仁异地处罚室（中队）","clbj":"1","jkbj":"0","wfjfs":"3","wfxwzt":"机动车违反禁止标线指示的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900331440","wfsj":"2013-12-02 09:29:58","wfbh":"4401132014131553820901","wfdz":"大观路奥体中心路段","wfxw":"1636","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900366851","wfsj":"2013-12-18 20:36:53","wfbh":"4401132014131553782981","wfdz":"金穗路冼村路路口","wfxw":"1345","fkje":"200","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车违反禁止标线指示的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900344262","wfsj":"2013-12-07 21:00:47","wfbh":"4401132014131553772401","wfdz":"广园西路环市西路至站西路路段","wfxw":"1345","fkje":"200","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"机动车违反禁止标线指示的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900338605","wfsj":"2013-12-05 15:11:54","wfbh":"4401132014131553820871","wfdz":"大观路奥体中心路段","wfxw":"1636","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900349855","wfsj":"2013-12-10 11:29:28","wfbh":"4401132014131553772371","wfdz":"大观路奥体中心路段","wfxw":"1636","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4407927900262830","wfsj":"2014-07-15 09:10:00","wfbh":"4407922014121902163721","wfdz":"西部沿海高速86KM+300M","wfxw":"1352A","fkje":"150","cljgmc":"江门市公安交通管理局高速公路交通警察二大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速10%未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137901237808","wfsj":"2014-12-09 14:54:52","wfbh":"4401132015131564682311","wfdz":"解放北路三元里大道路段","wfxw":"1345","fkje":"200","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"0","wfjfs":"3","wfxwzt":"机动车违反禁止标线指示的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4354047900011071","wfsj":"2015-05-31 15:08:00","wfbh":"4360042015141900080301","wfdz":"岳临高速398km+800m","wfxw":"1636","fkje":"150","cljgmc":"湖南省高速公路交通警察局郴州支队临武大队堡城警务站","clbj":"1","jkbj":"0","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900422469","wfsj":"2014-01-10 15:17:17","wfbh":"4401132014131553820291","wfdz":"大观路奥体中心路段","wfxw":"1636","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900417168","wfsj":"2014-01-09 13:24:16","wfbh":"4401132014131553782921","wfdz":"大观路奥体中心路段","wfxw":"1636","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900743763","wfsj":"2014-07-06 14:45:18","wfbh":"4401132014131553782711","wfdz":"大观路奥体中心路段","wfxw":"1636","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4360047900008643","wfsj":"2015-05-31 15:52:00","wfbh":"4360042015141900080311","wfdz":"岳临高速501km+800m","wfxw":"1636","fkje":"150","cljgmc":"湖南省高速公路交通警察局郴州支队临武大队堡城警务站","clbj":"1","jkbj":"0","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137902269782","wfsj":"2015-07-12 18:44:56","wfbh":null,"wfdz":"黄埔大道隧道路段","wfxw":"1721A","fkje":"1000","cljgmc":null,"clbj":"0","jkbj":"0","wfjfs":"12","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的机动车行驶超过规定时速50%以上的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4403097900210237","wfsj":"2014-05-27 16:06:08","wfbh":"4403092014192700620241","wfdz":"爱地大厦路段","wfxw":"83036","fkje":"300","cljgmc":"深圳市公安局交通警察支队口岸大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶机动车占用导流线行驶的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4353047900015473","wfsj":"2015-04-23 21:04:00","wfbh":"4360042015141900080281","wfdz":"岳临高速206km+350m","wfxw":"1352","fkje":"150","cljgmc":"湖南省高速公路交通警察局郴州支队临武大队堡城警务站","clbj":"1","jkbj":"0","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4360087900010849","wfsj":"2015-04-25 01:21:00","wfbh":"4360042015141900080291","wfdz":"岳临高速440km+100m","wfxw":"1352","fkje":"150","cljgmc":"湖南省高速公路交通警察局郴州支队临武大队堡城警务站","clbj":"1","jkbj":"0","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137901983823","wfsj":"2015-05-16 15:50:01","wfbh":"4401132015131564682531","wfdz":"南沙港快速路番禺区路段","wfxw":"6050","fkje":"0","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"9","wfjfs":"0","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的机动车超过规定时速10%以下的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137902240570","wfsj":"2015-07-11 15:09:01","wfbh":"4401132015131564682521","wfdz":"大广高速花山镇路段","wfxw":"1636","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"0","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137902243328","wfsj":"2015-07-12 04:10:08","wfbh":"4401132015131564682511","wfdz":"黄埔大道隧道西往东","wfxw":"1352A","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"0","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速10%未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4401137900730457","wfsj":"2014-06-28 19:18:24","wfbh":"4401132014131553782751","wfdz":"黄埔大道隧道路段","wfxw":"1352A","fkje":"150","cljgmc":"广州市公安局交通警察支队机动大队","clbj":"1","jkbj":"1","wfjfs":"3","wfxwzt":"驾驶中型以上载客载货汽车、危险物品运输车辆以外的其他机动车行驶超过规定时速10%未达20%的"},{"hphm":"粤S42N01","hpzl":"02","fdjh":"307709","xh":"4413927901305858","wfsj":"2015-05-14 15:55:16","wfbh":"4413922015121910177981","wfdz":"沈海高速公路惠州段2792公里150米","wfxw":"1636","fkje":"150","cljgmc":"惠州市公安局交通警察支队高速一大队白云中队","clbj":"1","jkbj":"1","wfjfs":"6","wfxwzt":"驾驶中型以上载客载货汽车、校车、危险物品运输车辆以外的其他机动车行驶超过规定时速20%以上未达到50%的"}],"signInfo":"5379126197832404D52528CF7A30D388","systemNo":"02","id":"IDCJDCWF151011181554","clientId":"1.0.0.2"}';

        return [ 'data' => json_decode( $search_result, true ), 'account' => $account ];
    }

    /**
     * 查询驾驶证扣分信息
     *
     * @param   $token          string
     * @param   $record_id      string
     * @param   $identity_id    string
     * @return  array
     */
    public static function license( $token, $identity_id, $record_id ){

        $http_params = [
            'method'    => 'GET',
            'uri'       => '/api/license',
            'query'     => [
                'token'         => $token,
                'recordID'      => $record_id,
                'identityID'    => $identity_id
            ]
        ];

        $search_result = static::send_request( $http_params );

        $search_result['data'] = json_decode( $search_result['data'], true );

		$search_result['data']['body'] = json_decode( $search_result['data']['body'], true  );

        return [ 'data' => $search_result['data'], 'account' => $search_result['account'] ];

        $account = $search_result['account'];

        $x = '{"time":"20151011105131","returnMessage":"123","clientId":"1.0.0.2","body":"{"ljjf":"0"}","id":"HDJSYJF0151011111515","systemNo":"02","signInfo":"FC6926620D7EAB7E3A7B2F368CE3BF27","returnCode":"1"}';

    	return [ 'data' => [ 'returnCode' => '1', 'body' => [ 'ljjf' => '0' ] ], 'account' => $account ];
    }

    /**
     * 查询车辆信息
     *
     * @param   $token          string
     * @param   $engineCode     string
     * @param   $licensePlate   string
     * @param   $licenseType    string
     * @return  array
     */
    public static function car( $token, $engineCode, $licensePlate, $licenseType ){

        $http_params = [
            'method'    => 'GET',
            'uri'       => '/api/car',
            'query'     => [
                'token'         => $token,
                'engineCode'    => $engineCode,
                'licenseType'   => $licenseType,
                'licensePlate'  => $licensePlate
            ]
        ];

        $search_result = static::send_request( $http_params );

        $search_result['data'] = json_decode( $search_result['data'], true );

        return [ 'data' => $search_result['data'], 'account' => $search_result['account'] ];

        $account = $search_result['account'];

        $search_result = '{"time":"20151011104127","returnMessage":"数据下载成功！","body":[{"fdjh":"8AD339525","yxqz":"2016-02-29 00:00:00","qzbfqz":"2099-12-31 00:00:00","zt":"A","cllx":"K33","ztmc":"正常","cllxmc":"小型轿车"}],"returnCode":"1","signInfo":"2986D2D01FFCFEE812F27E5D7593E9F7","systemNo":"02","id":"IDCJDCXX151011110511","clientId":"1.0.0.2"}';
    
    	return [ 'data' => json_decode( $search_result, true ), 'account' => $account ];
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
