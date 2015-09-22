<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::create( 'notices', function( $table ){

			/* 
			 * 主键：
			 * 		uniqid('tzzx', true)去标点共26位
			 */
			$table->string( 'notice_id' );
			$table->primary( 'notice_id' );

			/*
			 * 标题
			 */
			$table->string( 'title' );

			/*
			 * 内容
			 */
			$table->text( 'content' );

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

		Schema::dropIfExists( 'notices' );
	}
}
