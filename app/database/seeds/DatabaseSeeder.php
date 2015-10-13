<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('FeeTypesTableSeeder');
		// $this->call('NoticesTableSeeder');
		// $this->call('BusinessUsersTableSeeder');
		// $this->call('FeeTypesTableSeeder');
		// $this->call('FeedBacksTableSeeder');
	}

}