<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class FeeTypesTableSeeder extends Seeder {

	public function run()
	{
		// FeeType::create([
		// 	'item_id' => 1,
		// 	'category' => '普通充值',
		// 	'item' 	=> '普通充值',
		// 	'number' => ,
		// 	'flow_direction' => 1,
		// 	'user_type' => 0
		// ]);
		// FeeType::create([
		// 	'item_id' => 1,
		// 	'category' => '普通充值',
		// 	'item' 	=> '普通充值',
		// 	'number' => ,
		// 	'flow_direction' => 1,
		// 	'user_type' => 1
		// ]);

		FeeType::create([
			'item_id' => 2,
			'category' => '个人服务费',
			'item' 	=> '个人违章代办凭证快递费',
			'number' => 15,
			'flow_direction' => 1,
			'user_type' => 0
		]);
		FeeType::create([
			'item_id' => 3,
			'category' => '个人服务费',
			'item' 	=> '个人代办服务费',
			'number' => 30,
			'flow_direction' => 1,
			'user_type' => 0
		]);

		FeeType::create([
			'item_id' => 1,
			'category' => '企业服务费',
			'item' 	=> '企业违章代办凭证快递费',
			'number' => 15,
			'flow_direction' => 1,
			'user_type' => 1
		]);
		FeeType::create([
			'item_id' => 1,
			'category' => '企业服务费',
			'item' 	=> '3＝企业违章代办服务费',
			'number' => 30,
			'flow_direction' => 1,
			'user_type' => 1
		]);
		
	}

}