<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class NoticesTableSeeder extends Seeder {

	public function run()
	{	
		Notice::create([
			'title' 	=> '通知通知',
			'content' 	=> '车尚车服务欢迎您，车尚车服务欢迎您，车尚车服务欢迎您'
		]);
		Notice::create([
			'title' 	=> '通知通知',
			'content' 	=> '车尚车服务欢迎您，车尚车服务欢迎您，车尚车服务欢迎您'
		]);
		Notice::create([
			'title' 	=> '通知通知',
			'content' 	=> '车尚车服务欢迎您，车尚车服务欢迎您，车尚车服务欢迎您'
		]);
		Notice::create([
			'title' 	=> '通知通知',
			'content' 	=> '车尚车服务欢迎您，车尚车服务欢迎您，车尚车服务欢迎您'
		]);
	}

}