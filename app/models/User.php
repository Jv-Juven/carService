<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $primaryKey = 'user_id';

	protected $hidden = [
		'password',
		'permissions',
		'activation_code',
		'activated_at',
		'last_login',
		'persist_code',
		'reset_password_code',
		'first_name',
		'last_name'
	];

	protected $fillable = [
		'user_id',
		'login_account',
		'password',
		'status',
		'user_type',
		'remark_code',
		'remark_code',
		'created_at',
		'updated_at'
	];

	public static $id_prefix = 'yhxx';

	protected static function get_id_prefix(){
		return 'yhxx';
	}

	/*
	 * 获取费用表
	 */
	public function user_fee_ids(){

		return $this->hasMany( 'UserFee', 'user_id', 'user_id' );
	}

	/*
	 * 获取费用类型表
	 */
	public function fee_types(){

		return $this->hasManyThrough( 'FeeType', 'UserFee', 'user_id', 'item_id' );
	}

	/*
	 * 获取企业用户信息
	 */
	public function business_info(){

		return $this->hasOne( 'BusinessUser', 'user_id', 'user_id' );
	}

	/*
	 * 获取用户订单
	 */
	public function agency_orders(){

		return $this->hasOne( 'AgencyOrder', 'user_id', 'user_id' );
	}

	/* 
	 * 获取退款记录
	 */
	public function refund_records(){

		return $this->hasMany( 'RefundRecord', 'user_id', 'user_id' );
	}

	/*
	 * 获取消费记录
	 */
	public function cost_details(){

		return $this->hasMany( 'CostDetail', 'user_id', 'user_id' );
	}

	/*
	 * 获取已读通知的id
	 */
	public function notices_read_id(){

		return $this->hasMany( 'UserReadNotice', 'user_id', 'user_id' );
	}

	/*
	 * 获取已读通知信息
	 */
	public function notices_read(){

		return $this->hasManyThrough( 'Notice', 'UserReadNotice', 'user_id', 'notice_id' );
	}

	/*
	 * 获取用户反馈
	 */
	public function feedbacks(){

		return $this->hasMany( 'Feedback', 'user_id', 'user_id' );
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}
	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}
	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}
	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}
	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
}	
