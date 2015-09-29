<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeTypesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//费用类型表
		Schema::create( 'fee_types', function( $table ){

			/*
			 * 主键
			 * 		自增int，从1开始
			 */
			$table->increments('id');

			/*
			 * 分类名称，目前主要有两类：
			 * 		10	普通充值
			 *		20 	快递费
			 *		30  服务费
			 */
			$table->char('category', 8);

			/*
			 * 细项名称，分类的下一级
			 *		[普通充值]
			 *			1 	普通充值
			 *		[快递费]
			 * 			1 	个人用户快递费
			 * 			2 	企业用户快递费
			 *		[服务费]
			 *			1 	个人用户代办服务费
			 * 		 	2 	企业用户代办服务费
			 */
			$table->char('item', 8);

			/*
			 * 金额
			 */
			$table->float('number')->nullable();

			/*
			 * 流向
			 * 		对于操作主体而言，资金的流向，弃用
			 *		0 : 支出
			 *		1 : 收入
			 */
			$table->tinyInteger('flow_direction');

			/*
			 * 用户类型
			 * 		默认个人用户
			 * 		0 : 个人用户
			 *		1 : 企业用户
			 */
			$table->char('user_type', 2)->default('0');

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

		Schema::dropIfExists( 'fee_types' );
	}
}
