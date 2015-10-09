<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//反馈信息
		Schema::create( 'feedbacks', function( $table ){

			/*
			 * 主键:
			 * 		自增id,从1开始
			 */
			$table->increments( 'feedback_id' );

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
			 * 反馈类型	1＝咨询，2=建议，3=投诉
			 */
			$table->char('type', 16);

			/*
			 * 反馈标题
			 */
			$table->string('title');

			/*
			 * 反馈内容
			 */
			$table->text('content');

			/*
			 * 处理状态 0=未处理，1=已处理
			 */
			$table->boolean('status');

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

		Schema::dropIfExists( 'feedbacks' );
	}
}
