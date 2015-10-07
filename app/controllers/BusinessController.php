<?php

use GuzzleHttp\Client as httpClient;
use Guzzle\Common\Exception\GuzzleException;

class SearchException extends Exception{

}

class ParseException extends Exception{

}

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

	//算服务费
	public static function getServiceFee( $user_id = null )
	{
		/*
		$user = Sentry::getUser();
		try
		{
			$user_type = UserFee::where('user_id',$user->user_id)->where('item_id',3)->get();
		}catch(\Exception $e)
		{	
			$user_type = null;
		}
		$fee_type = FeeType::where('user_type',$user->user_type)
							->where('item_id',3)
							->first();
		// dd($fee_type->number);
		if(isset( $user_type ) )
		{
			$rep_service_charge = $user_type->fee_no;
		}else{
			$rep_service_charge = $fee_type->number;
		}
		return $rep_service_charge;
		*/

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

	//算快递费
	/*
	 * 修改同上
	 */
	public static function getExpressFee( $user_id = null )
	{
		/*
		//算快递费
		$user = Sentry::getUser();
		try
		{	
			$user_type = UserFee::where('user_id',$user->user_id)->where('item_id',2)->get();
		}catch(\Exception $e)
		{	
			$user_type = null;
		}
		$fee_type = FeeType::where('user_type',$user->user_type)
							->where('item_id',2)
							->first();
		// dd($fee_type->number);
		if(isset( $user_type ) )
		{
			$express_fee = $user_type->fee_no;
		}else{
			$express_fee = $fee_type->number;
		}
		*/

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

	//更改代办状态信息; $trade_status--交易状态; $process_status--处理状态
	public static function updateOrderStatus( $order_id, $trade_status, $process_status )
	{
		$order = AgencyOrder::find( $order_id );

		if( !isset( $order ) ){
			return false;
			//return array('errCode'=>21, 'message'=>'该订单不存在');
		}
			
		$order->trade_status 	= $trade_status;		// 交易状态
		$order->process_status 	= $process_status;		// 处理状态
		
		if( !$order->save() ){
			return false;
			//return array('errCode'=>22, 'message'=>'交易状态修改失败');
		}
			
		return true;
		//return array('errCode'=>0,'message'=>'交易状态修改成功');
	}

	//充值
	/**
	 * 注意，这种接口不应该直接开放给前端
	 * 应在支付后，收到微信/支付宝的通知并确认之后再调用
	 */
	public static function recharge( $number, $user_id = null )
	{

		//$money = Input::get('money');
		//if( !isset($money) )
		//	return array('errCode'=>21, 'message'=>'请填写充值金额');

		//验证token
		//$money_token = md5(time()); // md5算法是固定的，输入一样，输出就一样，这样毫无意义的
		//Session::put('money_token',$money_token);
		// $appkey ="csak7e90c28065cf11e5a76d031532dd8d5b";

//		$url = Config::get('domain.server').'/account/recharge';
//		$parm = 'appkey='.$appkey.'&money='.$money;
//		$recharge =  json_decode( CurlController::post($url,$parm), true);
/*
		if( $recharge == null )
			return array('errCode'=>22, 'message'=>'系统出现故障，请及时向客服反应');

		if( $recharge['errCode'] != 0 )
		{
			Log::info( $recharge );
			return parent::errMessage($recharge['errCode']);
		}

		return array('errCode'=>0, 'message'=>'充值成功','balance'=>$recharge['balance']);
*/

		if ( $user_id ){
			$user = User::find( $user_id );
		}else{
			$user = Sentry::getUser();	
		}

		// http 请求
		try{

			$http_client = static::getBaseHttpClient();
			$response = $http_client->request( 'POST', '/account/recharge', [
				'query' => [
					'appkey' 	=> Config::get( 'cheshang.appkey' ),
					'money'		=> $money
				]
			]);

			$response_content = json_decode( $response->getBody() );

			if ( static::isResponseSuccessful( $response_content ) ){
				return true;
			}

			// 服务器提供错误信息
			if ( array_key_exists( 'errMsg', $response_content ) ){

				$error_message = $response_content[ 'errMsg' ];
			}else{
				$error_message = '查询失败';
			}

			throw new SearchException( $error_message, $response_content['errCode'] );
		}
		/*
		 * 请求出错
		 * 错误种类可以查询http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
		 * 这里统一为GuzzleException
		 */
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

		// 返回boolean类型值
		return false;
	}

	//校验充值的token接口
	public function authToken()
	{
		// $token = Input::get('token');
		// $money_token = Session::pull('money_token');
		// if($token == null)
		// 	return array('errCode'=>21, 'message'=> 'token不正确,无效充值');

		// if( $token != $money_token)
		// 	return array('errCode'=>22, 'message'=> 'token不正确,无效充值');

		return Response::json( array('errCode'=>0, 'message'=>'token正确,有效充值') );
	}

	//获取访问次数信息
	public static function count( $user_id = null )
	{
		/*
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account/count?appkey='.$appkey;
		$count =  json_decode( CurlController::get($url), true);
		
		if($count == null)
			return array('errCode'=>21, 'message'=>'系统出现故障，请及时向客服反应');

		if( $count['errCode'] != 0)
		{
			Log::info( $count );
			return parent::errMessage($count['errCode']);
		}
		// dd($count['data']);
		return array('errCode'=>0, 'message'=>'获取访问次数信息成功','count'=>$count['data']);
		*/

		if ( $user_id ){
			$user = User::find( $user_id );
		}else{
			$user = Sentry::getUser();
		}

		if ( $user->is_common_user() ){
			
		}

		// http 请求
		try{

			$http_client = static::getBaseHttpClient();
			$response = $http_client->request( 'GET', '/account/count', [
				'query' => [
					'appkey' 	=> Config::get( 'cheshang.app_key' )
				]
			]);

			$response_content = json_decode( $response->getBody() );

			// 是否成功
			if ( static::isResponseSuccessful( $response_content ) ){
				return $response_content[ 'data' ];
			}

			// 服务器提供错误信息
			if ( array_key_exists( 'errMsg', $response_content ) ){

				$error_message = $response_content[ 'errMsg' ];
			}else{
				$error_message = '查询失败';
			}

			throw new SearchException( $error_message, $response_content['errCode'] );
		}
		/*
		 * 请求出错
		 * 错误种类可以查询http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
		 * 这里统一为GuzzleException
		 */
		catch( GuzzleException $e ){

//			static::logError( $user->user_id, 'count', $e->getMessage() );
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

	//获取账户信息
	public static function accountInfo( $user_id = null )
	{
		/*
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		$url = Config::get('domain.server').'/account?appkey='.$appkey;

		$account_info = json_decode( CurlController::get($url),true );

		if($account_info == null)
			return array('errCode'=>21, 'message'=>'系统出现故障，请及时向客服反应');

		if( $account_info['errCode'] != 0)
		{
			Log::info( $account_info );
			return parent::errMessage($account_info['errCode']);
		}

		return array('errCode'=>0,'message'=>'返回账户信息','account'=>$account_info['account']);
		*/

		if ( $user_id ){
			$user = User::find( $user_id );
		}else{
			$user = Sentry::getUser();	
		}

		if ( $user->is_business_user() ){

		}

		// http 请求
		try{

			$http_client = static::getBaseHttpClient();
			$response = $http_client->request( 'GET', '/account', [
				'query' => [
					'appkey' 	=> Config::get( 'cheshang.app_key' )
				]
			]);
			
			$response_content = json_decode( $response->getBody() );

			// 是否成功
			if ( static::isResponseSuccessful( $response_content ) ){
				return $response_content[ 'account' ];
			}

			// 服务器提供错误信息
			if ( array_key_exists( 'errMsg', $response_content ) ){

				$error_message = $response_content[ 'errMsg' ];
			}else{
				$error_message = '查询失败';
			}

			throw new SearchException( $error_message, $response_content['errCode'] );
		}
		/*
		 * 请求出错
		 * 错误种类可以查询http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
		 * 这里统一为GuzzleException
		 */
		catch( GuzzleException $e ){

//			static::logError( $user->user_id, 'accountInfo', $e->getMessage() );
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

	//修改业务单价<<<<<<管理员接口>>>>>>>
	public static function univalence( $violation = null, $license = null, $car = null )
	{	
		/*
		$violation 		= Input::get('violation');
		$license 		= Input::get('license');
		$car 			= Input::get('car');
		$appkey = BusinessUser::find(Sentry::getUser()->user_id)->app_key;
		// dd($appkey);
		$url = Config::get('domain.server').'/account/univalence';
		$parm = 'appkey='.$appkey.'&violation='.urlencode( $violation ).'&license='.urlencode( $license ).'&car='.urlencode( $car );
		//修改业务单价
		$account_info = json_decode( CurlController::post($url,$parm),true );

		if($account_info == null)
			return array('errCode'=>21, 'message'=>'系统出现故障，请及时向客服反应');

		if( $account_info['errCode'] != 0)
		{
			Log::info( $account_info );
			return parent::errMessage($account_info['errCode']);
		}

		return array('errCode'=>0,'message'=>'修改业务单价', 'account_info'=>$account_info['account']) ;
		*/
		$query = [
			'appkey'	=> Config::get( 'cheshang.app_key' ),
			'violation'	=> $violation,
			'license'	=> $license,
			'car'		=> $car
		];

		// http 请求
		try{

			$http_client = static::getBaseHttpClient();
			$response = $http_client->request( 'POST', '/account/univalence', [
				'query' => array_filter( $query ) 		// 需过滤
			]);

			$response_content = json_decode( $response->getBody() );

			if ( static::isResponseSuccessful() ){
				return true;
			}

			// 服务器提供错误信息
			if ( array_key_exists( 'errMsg', $response_content ) ){

				$error_message = $response_content[ 'errMsg' ];
			}else{
				$error_message = '查询失败';
			}

			throw new SearchException( $error_message, $response_content['errCode'] );
		}

		/*
		 * 请求出错
		 * 错误种类可以查询http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
		 * 这里统一为GuzzleException
		 */
		catch( GuzzleException $e ){

//			static::logError( $user->user_id, 'univalence', $e->getMessage() );
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

		return false;
	}

	//违章查询
	public static function violation( $token, $engineCode, $licensePlate, $licenseType )
	{
		// 验证的代码写在外面，这里就发送请求，将结果简单处理然后返回
		/*
		$query = array(
				//车牌号码
				'req_car_plate_no' 	=> Input::get('req_car_plate_no'),
				//发动机号码后6位
				'req_car_engine_no' => Input::get('req_car_engine_no'),
				//车辆类型
				'car_type_no' 		=> Input::get('car_type_no')
			);
		$rules = array(
				'req_car_plate_no' 	=> 'required|size:7',
				'req_car_engine_no' => 'required|size:6',
				'car_type_no' 		=> 'required|size:2'
			);

		$messages = array(
				'req_car_plate_no.required'  => 21,
				'req_car_engine_no.required' => 21,
				'car_type_no.required'  	 => 21,
				'req_car_plate_no.size'		 => 22, 
				'req_car_engine_no.size'	 => 23,
				'car_type_no.size'		 	 => 24
			);

		$validation = Validator::make($query, $rules,$messages);
		if($validation->fails())
		{
			$number = $validation->messages()->all();
			switch ($number[0]) {
				case 21:
					return array('errCode'=>21, 'message'=>'请将信息填写完整');
					break;
				case 22:
					return array('errCode'=>22, 'message'=>'车牌号码位数不正确');
					break;
				case 23:
					return array('errCode'=>23, 'message'=>'发动机号码位数不正确');
					break;
				default:
					return array('errCode'=>24, 'message'=>'车架号码位数不正确');
					break;
			}
		}
		*/
		
		/*
		$token = parent::token();
		$url = Config::get('domain.server').'/api/violation?token='.$token.
				'&licensePlate='.$data['req_car_plate_no'].'&engineCode='.
				$data['req_car_engine_no'].'&licenseType='.$data['car_type_no'];
		$violation = json_decode( CurlController::get($url), true );
		// $violation =  CurlController::get($url);
			// dd($violation);
		if($violation == null)
			return array('errCode'=>25, 'message'=>'系统出现故障，请及时向客服反应');

		if( $violation['errCode'] != 0)
		{
			Log::info( $violation );
			return parent::errMessage($violation['errCode']);
		}

		$violation = json_decode( $violation['data'],true);
		if(isset($violation['body'][0]['tips']))
			return array('errCode'=>26, 'message'=>'车牌号码或号牌种类错误');

		//把违章信息存入session中，以便提交订单时生成
		Session::put('violation',$violation['body']);
		return array('errCode'=>0, 'message'=>'获取车辆违章信息','violations'=>$violation['body']);
		*/

		try{

			$http_client = static::getBaseHttpClient();
			$response = $http_client->request( 'GET', '/api/violation', [
				'query' => [
					'token'			=> $token
					'engineCode' 	=> $engineCode,
					'licensePlate'	=> $licensePlate,
					'licenseType'	=> $licenseType
				]
			]);
			
			$response_content = json_decode( $response->getBody() );

			if ( static::isResponseSuccessful( $response_content ) ){

				return $response_content['body'];
			}

			// 服务器提供错误信息
			if ( array_key_exists( 'errMsg', $response_content ) ){

				$error_message = $response_content[ 'errMsg' ];
			}else{
				$error_message = '查询失败';
			}

			throw new SearchException( $error_message, $response_content['errCode'] );
		}

		/*
		 * 请求出错
		 * 错误种类可以查询http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
		 * 这里统一为GuzzleException
		 */
		catch( GuzzleException $e ){

//			static::logError( $user->user_id, 'violation', $e->getMessage() );
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

	//查询驾驶证扣分信息
	public static function license( $token, $identity_id, $record_id )
	{
		/*
		$identityID = Input::get('identityID');
		$recordID   = Input::get('recordID');
		$data = array(
				//身份证号码/驾驶证号码
				'identityID' 	=> Input::get('identityID'),
				//档案号码
				'recordID' 		=> Input::get('recordID'),
			);
		$rules = array(
				'identityID' 	=> 'required',
				'recordID' 		=> 'required',
			);
		$validation = Validator::make($data, $rules);

		if($validation->fails())
			return array('errCode'=>21, 'message'=>'请填写完整的信息');

		 $token = parent::token();
		 $url = Config::get('domain.server').'/api/license?token='.$token.'&identityID='.
		 					$data['identityID'].'&recordID='.$data['recordID'];
		 $license = json_decode( CurlController::get($url),true );
		// dd($license);
		if($license == null)
			return array('errCode'=>22, 'message'=>'系统出现故障，请及时向客服反应');

		 if( $license['errCode'] != 0 )
		 {
		 	Log::info( $license );
			return parent::errMessage($license['errCode']);
		 }
		 $license = json_decode( $license['data'],true);
		 
		 if($license['returnCode'] == 0)
		 {
		 	return array('errCode'=>23,'message'=>'身份证号码，驾驶证号码或档案号码错误');
		 }
		 $license = json_decode( $license['body'],true);

		 return array('errCode'=>0, 'message'=>'驾驶证扣分分数','number'=>$license['ljjf']);
		 */
		try{

			$http_client = static::getBaseHttpClient();
			$response = $http_client->request( 'GET', '/api/license', [
				'query' => [
					'token'			=> $token,
					'identityID'	=> $identity_id,
					'recordID'		=> $record_id
				]
			]);

			$response_content = json_decode( $response->getBody() );

			if ( static::isResponseSuccessful( $response_content ) ){

				return $response_content['body'];
			}

			// 服务器提供错误信息
			if ( array_key_exists( 'errMsg', $response_content ) ){

				$error_message = $response_content[ 'errMsg' ];
			}else{
				$error_message = '查询失败';
			}

			throw new SearchException( $error_message, $response_content['errCode'] );
		}
		/*
		 * 请求出错
		 * 错误种类可以查询http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
		 * 这里统一为GuzzleException
		 */
		catch( GuzzleException $e ){

//			static::logError( $user->user_id, 'license', $e->getMessage() );
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

	//查询车辆信息
	public static function car( $token, $engineCode, $licensePlate, $licenseType )
	{
		/*
		$data = array(
			'engineCode'		=> Input::get('engineCode'),//发动机号后六位
			'licensePlate' 		=> Input::get('licensePlate'),//车牌号码
			'licenseType' 		=> Input::get('licenseType')//车辆类型
		);

		$rules = array(
			'engineCode' 		=> 'required|size:6',
			'licensePlate' 		=> 'required|size:7',
			'licenseType' 		=> 'required|size:2',
		);

		$messages = array(
				'engineCode.required'  	=> 1,
				'licensePlate.required' => 1,
				'licenseType.required'  => 1,
				'engineCode.size'		=> 2, 
				'licensePlate.size'		=> 3,
				'licenseType.size'	 	=> 4
		);

		$validation = Validator::make($data,$rules,$messages);

		if($validation->fails())
		{
			$number = $validation->messages()->all();
			switch ($number[0]) {
				case 1:
					return array('errCode'=>21,'message'=>'信息填写不完整');
					break;
				case 2:
					return array('errCode'=>22,'message'=>'发动机后6位格式不正确');
					break;
				case 3:
					return array('errCode'=>23,'message'=>'车牌号码格式不正确');
					break;
				default:
					return array('errCode'=>24,'message'=>'车辆类型格式不正确');
					break;
			}
		}
		
		$token = parent::token();
		$url = Config::get('domain.server').'/api/car?token='.$token.'&engineCode='.
		 					$data['engineCode'].'&licensePlate='.$data['licensePlate'].
		 					'&licenseType='.$data['licenseType'];
		$car = json_decode( CurlController::get($url),true );
		
		if($car == null)
			return array('errCode'=>25, 'message'=>'系统出现故障，请及时向客服反应');

		if( $car['errCode'] != 0 )
		{
			Log::info( $car );
			return parent::errMessage($car['errCode']);
		}
		$car = json_decode( $car['data'],true);
		// $car = $car['body'];
		if( $car['returnCode'] == 0)
			return array('errCode'=>26, 'message'=>'没有车辆信息，请查看信息是否填写正确');
	
		return array('errCode'=>0, 'message'=>'车辆信息','car'=>$car['body']);
		*/
		try{

			$http_client = static::getBaseHttpClient();
			$response = $http_client->request( 'GET', '/api/car', [
				'query' => [
					'token'			=> $token,
					'engineCode'	=> $engineCode,
					'licensePlate'	=> $licensePlate,
					'licenseType'	=> $licenseType
				]
			]);

			$response_content = json_decode( $response->getBody() );

			if ( static::isResponseSuccessful( $response_content ) ){

				return $response_content['body'];
			}

			// 服务器提供错误信息
			if ( array_key_exists( 'errMsg', $response_content ) ){

				$error_message = $response_content[ 'errMsg' ];
			}else{
				$error_message = '查询失败';
			}

			throw new SearchException( $error_message, $response_content['errCode'] );
		}

		/*
		 * 请求出错
		 * 错误种类可以查询http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
		 * 这里统一为GuzzleException
		 */
		catch( GuzzleException $e ){

//			static::logError( $user->user_id, 'car', $e->getMessage() );
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

	//提交订单
	public static function submitOrder()
	{	
		$violations = json_decode( Input::get('violations'));
		$violations = Session::get('violation');
		if($violations == null )
			return array('errCode'=>21, 'message'=>'请传入违章信息');

		$is_delivered = Input::get('is_delivered');//是否需要快递
		$data_two = array(
			'recipient_name' 	=> Input::get('recipient_name'),//收件人姓名
			'recipient_addr' 	=> Input::get('recipient_addr'),//收件人地址
			'recipient_phone' 	=> Input::get('recipient_phone'),//收件人手机
			'car_engine_no'		=> Input::get('car_engine_no')//发动机后4位
		);
		$rules_two = array(
			'recipient_name'	=> 'required',
			'recipient_addr'	=> 'required',
			'recipient_phone'	=> 'required',
			'car_engine_no'		=> 'required'
		);
		//判断是否需要快递费
		if( $is_delivered == true )
		{
			$validation_two = Validator::make($data_two,$rules_two);
			if($validation_two->fails())
				return array('errCode'=>22, 'message'=>'收件人信息填写不完整');
			$expressfee = BusinessController::expressFee();
		}else{
			$expressfee = 0;
		}

		$capital_sum = null; //订单本金总额
		foreach( $violations as $violation)
		{
			$capital_sum +=	$violation['fkje'];
		}

		//验证手机
		$phone_regex = Config::get('regex.telephone');
		if(!preg_match($phone_regex, $data_two['recipient_phone']))
			return array('errCode'=>23,'message'=>'手机号码有误');

		if(!strlen($data_two['car_engine_no']))
			return array('errCode'=>24,'message'=>'发动机后4位格式不正确，请填写4位');

		try
		{
			DB::transaction(function() use($violations,$data_two,$capital_sum,$expressfee) {

				$order = new AgencyOrder;
				$order->order_id 			= str_replace('.', '', uniqid( 'dbdd', true ));
				$order->user_id 			= Sentry::getUser()->user_id;
				$order->car_plate_no 		= $violations[0]['hphm'];//车牌号码
				$order->agency_no 			= count($violations);//代理数量
				$order->capital_sum 		= $capital_sum;//本金总额
				$order->service_charge_sum 	= BusinessController::serviceFee();//服务费
				$order->express_fee 		= $expressfee;//快递费
				$order->recipient_name 		= $data_two['recipient_name'];
				$order->recipient_addr 		= $data_two['recipient_addr'];
				$order->recipient_phone 	= $data_two['recipient_phone'];
				$order->car_engine_no 		= $data_two['car_engine_no'];
				$order->trade_status 		= 0;//交易状态－等待付款
				$order->process_status 		= 0;//处理状态－未受理

				//在save后不能再取其值
				$order_id = $order->order_id;
				$order->save();
				
				//违章信息存储
				foreach( $violations as $violation )
				{
					$violation_info = new TrafficViolationInfo;
					$violation_info->traffic_id 			= str_replace('.', '', uniqid( 'wzxx', true ));
					$violation_info->order_id 				= $order_id;
					$violation_info->req_car_plate_no 		= $violation['hphm'];	//车牌号码
					$violation_info->req_car_engine_no 		= $violation['fdjh'];	//发动机号后六位
					$violation_info->car_type_no 			= $violation['hpzl'];	//号牌种类
					$violation_info->rep_event_time 		= $violation['wfsj'];	//违法时间
					$violation_info->rep_event_addr 		= $violation['wfdz'];	//违法地址
					$violation_info->rep_violation_behavior = $violation['wfxwzt'];	//违法行为
					$violation_info->rep_point_no 			= $violation['wfjfs'];	//违法记分数
					$violation_info->rep_priciple_balance 	= $violation['fkje'];	//罚款金额
					$violation_info->rep_service_charge 	= BusinessController::serviceFee();
					$violation_info->save();
				}
			});
		}catch(\Exception $e)
		{
			return array('errCode'=>25,'message'=>'操作失败'.$e->getMessage() );
		}
		$data['order_id']			= AgencyOrder::where('user_id',Sentry::getUser()->user_id)
												->orderBy('created_at','desc')
												->first()
												->order_id;
		$data['recipient_name'] 	= $data_two ['recipient_name'];
		$data['recipient_addr'] 	= $data_two ['recipient_addr'];
		$data['recipient_phone'] 	= $data_two ['recipient_phone'];
		$data['car_plate_no']		= $violations[0]['hphm'];
		$data['agency_no']			= count($violations);
		$data['capital_sum']		= $capital_sum;
		$data['service_charge_sum'] = BusinessController::serviceFee();
		$data['express_fee']		= $expressfee;

		return array('errCode'=>0,'message'=>'返回订单信息','order'=>$data);
	}

	//查看违章代办信息
	public function trafficViolationInfo()
	{
		$user = Sentry::getUser();
		$orders = AgencyOrder::where('user_id',$user->user_id)
								->with('traffic_violation_info')
								->orderBy('created_at','asc')
								->get();

		return array('errCode'=>0, 'message'=>'违章代办信息', 'orders'=>$orders);
	}
}