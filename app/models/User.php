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
	protected $table 		= 'users';
	protected $primaryKey 	= 'user_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
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
}
