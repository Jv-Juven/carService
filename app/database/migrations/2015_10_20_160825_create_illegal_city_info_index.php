<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIllegalCityInfoIndex extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('illegal_city_info_index', function(Blueprint $table)
		{
			$table->increments('id');
			//省
			$table->integer('p_code')->unsigned()->index('p_code');
			$table->string('province')->nullable();
			//市
			$table->integer('c_code')->unsigned()->index('c_code');
			$table->string('city')->nullable();
			//区
			$table->integer('a_code')->unsigned()->index('a_code');
			$table->string('area')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('illegal_city_info_index');
	}

}
