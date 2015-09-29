<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		
		//违章代办订单表
		Schema::create( 'agency_orders', function( $table ){

			/*
			 * 订单id
			 * 		作为主键
			 * 		uniqid('dbdd', true)去标点共26位
			 */
			$table->string('order_id');
			$table->primary('order_id');

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
			 * 支付平台
			 * 		0：微信
			 * 		1：支付宝
			 */
			$table->tinyInteger('pay_platform')->nullable();
			
			/*
			 * 支付时间
			 */
			$table->datetime('pay_time')->nullable();
			
			/*
			 * 第三方支付平台交易流水号
			 * 		微信32位
			 * 		支付宝64位
			 */
			$table->char('pay_trade_no', 64)->nullable();
			$table->unique('pay_trade_no');
			
			/*
			 * 车牌号
			 */
			$table->char('car_plate_no', 8);
			
			/*
			 * 代办订单数量
			 */
			$table->integer('agency_no');
			
			/*
			 * 代办订单的本金总额
			 */
			$table->float('capital_sum');
			
			/*
			 * 代办订单的滞纳金总额
			 */
			$table->float('late_fee_sum');
			
			/*
			 * 代办订单的服务费总额
			 */
			$table->float('service_charge_sum');
			
			/*
			 * 是否快递
			 * 		0 : 否
			 * 		1 : 是
			 */
			$table->boolean('is_delivered')->default(false);
			
			/*
			 *  交易状态
			 * 		0 : 等等付款
			 * 		1 : 已付款
			 * 		2 : 申请退款
			 * 		3 : 已退款
			 * 		4 : 退款失败
			 */
			$table->char('trade_status', 2)->default('0');
			
			/*
			 *  处理状态
			 * 		0 : 未受理
			 * 		1 : 已受理
			 * 		2 : 已受理办理中
			 * 		3 : 订单完成
			 * 		4 : 订单关闭
			 */
			$table->char('process_status', 2);
			
			/*
			 * 快递费
			 * is_delivered
			 */
			$table->float('express_fee')->nullable();
			
			/*
			 * 快递收件人姓名
			 */
			$table->string('recipient_name', 25)->nullable();
			
			/*
			 * 收件人地址
			 */
			$table->string('recipient_addr')->nullable();
			
			/*
			 * 收件人手机号
			 */
			$table->char('recipient_phone', 11)->nullable();
			
			/*
			 * 发动机后四位
			 */
			$table->char('car_engine_no', 4)->nullable();

			/*
			 * 号牌种类名称，只存数字编号，
			 */
			$table->char('car_type_no',2);

			/*
			 * Laravel自动维护
			 * created_at: 创建时间 即订单提交时间
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
		
		Schema::dropIfExists( 'agency_orders' );
	}
}
