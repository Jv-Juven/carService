<?php

class OrderAuthInfo extends Eloquent{

	protected $table = 'order_authinfos';

	protected $hidden       = [];
	protected $fillable 	= array(
			'transactionId',//交易号
			'transactionFee'//费用
	);
}