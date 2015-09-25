<?php

class PayController extends BaseController{

	public function recharge()
	{
		$money = Input::get('money');
		if( !isset($money));
			return Response::json(array('errCode'=>1, 'message'=>'请填写充值金额'));

		$appkey = BusinessUser::find(Sentry::getUser()->user_id);
		$url = Config::get('domain.server').'/account/recharge';
		$parm = 'appkey='.urlencode($appkey).'&money='.$money;

		$recharge = CurlController::post($url,$parm);

		return $recharge;
	}
}