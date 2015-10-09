<?php

class FeedBacksTableSeeder extends Seeder {

	public function run()
	{
		$users = User::all();

		for ($i = 0; $i < count($users); $i++) { 
			$user = $users[$i];

			FeedBack::create([
				"user_id" => $user->user_id,
				"type" => "1",
				"title" => "title_" . $i . "_type_1_untreated",
				"status" => false,
				"content" => "content_" . $i . "_type_1_untreated",
			]);

			FeedBack::create([
				"user_id" => $user->user_id,
				"type" => "1",
				"title" => "title_" . $i . "_type_1_treated",
				"status" => true,
				"content" => "content_" . $i . "_type_1_treated",
			]);

			FeedBack::create([
				"user_id" => $user->user_id,
				"type" => "2",
				"title" => "title_" . $i . "_type_2_untreated",
				"status" => false,
				"content" => "content_" . $i . "_type_2_untreated",
			]);

			FeedBack::create([
				"user_id" => $user->user_id,
				"type" => "2",
				"title" => "title_" . $i . "_type_2_treated",
				"status" => true,
				"content" => "content_" . $i . "_type_2_treated",
			]);

			FeedBack::create([
				"user_id" => $user->user_id,
				"type" => "3",
				"title" => "title_" . $i . "_type_3_untreated",
				"status" => false,
				"content" => "content_" . $i . "_type_3_untreated",
			]);

			FeedBack::create([
				"user_id" => $user->user_id,
				"type" => "3",
				"title" => "title_" . $i . "_type_3_treated",
				"status" => true,
				"content" => "content_" . $i . "_type_3_treated",
			]);
		}
	}
}