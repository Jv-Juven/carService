<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::create( 'cost_details', function( $table ){

			/* 
			 * 主键:
			 * 		uniqid('fyxx',true)去标点，共26位	
			 */
			$table->string('cost_id');

			/*
			 * 用户id
			 * 		作为外键 -- users表主键
			 */
			$table->string('user_id');
			$table->index('user_id');
			$table->foreign('user_id')
				  ->references('user_id')
				  ->on('users')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');

			/*
			 * 用户id
			 * 		作为外键 -- users表主键
			 */
			$table->string('item_id');
			$table->index('item_id');
			$table->foreign('item_id')
				  ->references('item_id')
				  ->on('fee_types')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');

			/*
			 * 因费用类型不同而含义不同
			 *		充值金额
			 */
			$table->float('number');

			/*
			 * Laravel自动维护
			 * created_at: 
			 * 		创建时间
			 *	 		因费用类型不同而作用不同
			 *			[普通充值]判断时精确到时分秒
			 * updated_at: 修改时间
			 */
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){

		Schema::dropIfExists( 'cost_details' );
	}
}
