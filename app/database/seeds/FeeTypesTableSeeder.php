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

		// 普通充值
		FeeType::create([
			'category' => '10',
			'item' 	=> '0',
			'number' => 15,
			'flow_direction' => 1,
			'user_type' => 0
		]);
		FeeType::create([
			'category' => '20',
			'item' 	=> '0',
			'number' => 15,
			'flow_direction' => 1,
			'user_type' => 0
		]);

		FeeType::create([
			'category' => '20',
			'item' 	=> '1',
			'number' => 20,
			'flow_direction' => 1,
			'user_type' => 1
		]);

		FeeType::create([
			'category' => '30',
			'item' 	=> '0',
			'number' => 15,
			'flow_direction' => 1,
			'user_type' => 0
		]);

		FeeType::create([
			'category' => '30',
			'item' 	=> '1',
			'number' => 20,
			'flow_direction' => 1,
			'user_type' => 1
		]);	
	}
}