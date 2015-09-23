<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReadNoticeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::create( 'user_read_notice', function( $table ){

			/*
			 * 外键
			 *		约束：users表user_id字段
			 */
			$table->string('user_id');
			$table->index('user_id');
			$table->foreign('user_id')
				  ->references('user_id')
				  ->on('users')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');

			/*
			 * 外键
			 *		约束：notices表notice_id字段
			 */
			$table->string('notice_id');
			$table->index('notice_id');
			$table->foreign('notice_id')
				  ->references('notice_id')
				  ->on('notices')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');

			/*
			 * 设置联合主键
			 */
			$table->primary([
				'user_id',
				'notice_id'
			]);

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
		
		Schema::dropIfExists( 'user_read_notice' );
	}
}
