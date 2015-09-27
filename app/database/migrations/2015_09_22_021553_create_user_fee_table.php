<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
						//用户费用表
		Schema::create( 'user_fee', function( $table ){

			/*
			 * 主键之一 & 外键
			 * 		约束: users表user_id字段
			 */
			$table->string('user_id');
			$table->index('user_id');
			$table->foreign('user_id')
				  ->references('user_id')
				  ->on('users')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');
			
			/*
			 * 主键之一 & 外键
			 * 		约束: fee_types表item_id字段
			 */
			$table->integer('fee_type_id')
			 	  ->unsigned();
			$table->index('fee_type_id');
			// $table->foreign('fee_type_id')
			// 	  ->references('id')
			// 	  ->on('fee_types')
			// 	  ->onDelete('cascade')
			// 	  ->onUpdate('cascade');

			/*
			 * 设置联合主键: (user_id, item_id) 
			 */
			$table->primary([
				'user_id',
				// 'fee_type_id'
			]);

			/*
			 * 费用
			 */
			$table->float('fee_no')->nulllable();

			/*
			 * Laravel自动维护
			 * created_at: 创建时间
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

		Schema::dropIfExists( 'user_fee' );
	}
}
