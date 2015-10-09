<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		Sentry::register([
			'login_account'	=> '8888@qq.com',
			'password' 		=> 666666,
			'status'		=> 22,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> '666666@qq.com',
			'password' 		=> 666666,
			'status'		=> 22,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'hulin@qq.com',
			'password' 		=> 666666,
			'status'		=> 22,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'unactived@qq.com',
			'password' 		=> 666666,
			'status'		=> 10,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'unsigned@qq.com',
			'password' 		=> 666666,
			'status'		=> 11,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'unchecked@qq.com',
			'password' 		=> 666666,
			'status'		=> 20,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'unchecked2@qq.com',
			'password' 		=> 666666,
			'status'		=> 20,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'unchecked3@qq.com',
			'password' 		=> 666666,
			'status'		=> 20,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'unchecked4@qq.com',
			'password' 		=> 666666,
			'status'		=> 20,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'checked@qq.com',
			'password' 		=> 666666,
			'status'		=> 21,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);

		Sentry::register([
			'login_account'	=> 'locked@qq.com',
			'password' 		=> 666666,
			'status'		=> 30,
			'user_type'		=> 1, 
			'remark_code' 	=> 666666,
			'activated' 	=> 1
		]);
	}

}