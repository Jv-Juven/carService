<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAuthinfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_authinfos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('transactionId')->nullable();//交易单号
			$table->integer('transactionFee')->nullable();//交易金额
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
		Schema::drop('order_authinfos');
	}

}
