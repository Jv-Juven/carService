<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class BusinessUsersTableSeeder extends Seeder {

	public function run()
	{
		$users = User::all();

		for($i = 0, $length = count($users); $i < $length; $i ++) {
			BusinessUser::create([
				'user_id' => $users[$i]->user_id,
				"business_name" => "企业名称_" . ($i + 1),
				"business_licence_no" => "1111111111111111" . ($i + 1),
				"business_licence_scan_path" => "http://7sbxao.com1.z0.glb.clouddn.com/avatar.jpg",
				"operational_name" => "logan",
				"operational_card_no" => "480023196807150234" . ($i + 1),
				"operational_phone" => "15902345624" . ($i + 1),
				"bank_account" => "315247183127" . ($i + 1),
				"deposit_bank" => "工商银行",
				"bank_outlets" => "大韩民国宇宙中心支行",
				"id_card_front_scan_path" => "http://7sbxao.com1.z0.glb.clouddn.com/avatar.jpg",
				"id_card_back_scan_path" => "http://7sbxao.com1.z0.glb.clouddn.com/avatar.jpg" 
			]);
		}
			
	}

}