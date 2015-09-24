<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class BusinessUsersTableSeeder extends Seeder {

	public function run()
	{
			BusinessUser::create([
				'user_id' =>'yhxx560218325bc86201544229'
			]);
	}

}