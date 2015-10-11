<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//退款记录表
		Schema::create( 'refund_records', function( $table ){

			/*
			 * 主键
			 * 		uniqid('tkjl', true)去标点，共26位
			 */
			$table->string('refund_id');
			$table->primary('refund_id');

			/*
			 * 外键
			 * 		约束: agency_orders表oreder_id字段
			 */
			$table->string('order_id');
			$table->index('order_id');
			$table->foreign('order_id')
				  ->references('order_id')
				  ->on('agency_orders')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');

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
			 * 运营人员审批退款时间
			 */
			$table->datetime('approval_at')->nullable();

			/*
			 * 退款状态: 默认状态审核中
			 *		0 : 审核中
			 *		1 : 审核通过退款中
			 *		2 : 退款成功
			 *		3 : 审核不通过
			 *		4 : 退款失败
			 */
			$table->char('status', 2)->default('0');

			/*
			 * Laravel自动维护
			 * created_at: 创建时间 即申请退款时间
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

		Schema::dropIfExists( 'refund_records' );
	}
}
