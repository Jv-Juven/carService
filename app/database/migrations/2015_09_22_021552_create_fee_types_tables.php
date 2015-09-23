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
			 * 		uniqid('fylx',true)去标点，共26位
			 */
			$table->string('item_id');
			$table->primary('item_id');

			/*
			 * 分类名称，目前主要有两类：
			 *		消费：违章查询／驾驶证查询／车辆查询产生的费用，适用企业用户
			 *		普通充值：充值，以便账户余额有足够费用可消费，适用企业用户
			 *		企业服务费：代办／待寄等业务产生的服务费用
			 *		个人服务费：违章代办／待寄等业务产生的费用
			 */
			$table->string('category');

			/*
			 * 细项名称，分类的下一级
			 *		[消费]
			 *			违章查询
			 *			驾驶证查询
			 *			车辆查询
			 *		[服务费]
			 *		票证快递费 15
			 *			企业用户违章代办 10
			 *			个人用户违章代办 30
			 *		[普通充值]
			 *			普通充值 null 按充值金额
			 */
			$table->string('item');

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
