<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//反馈信息
		Schema::create( 'admins', function( $table ){

			/*
			 * 主键:
			 * 		自增id,从1开始
			 */
			$table->increments( 'admin_id' );

			/*
			 * 用户名
			 */
			$table->string('username')->unique();

			/*
			 * 电子邮件
			 */
			$table->string('email')->nullable();

			/*
			 * 用户密码
			 */
			$table->string('password');

			/*
			 * 找回密码的token
			 */
			$table->string('remember_token', 256);

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

		Schema::dropIfExists( 'admins' );
	}
}
