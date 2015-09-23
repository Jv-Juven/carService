<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrafficViolationInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
						//违章信息表
		Schema::create( 'traffic_violation_info', function( $table ){

			/*
			 * 主键
			 * 		uniqid('wzxx', true), 去标点后26位
			 */
			$table->string('traffic_id');
			$table->primary('traffic_id');

			/*
			 * 外键
			 * 		约束: 表agency_orders字段order_id
			 */
			$table->string('order_id');
			$table->index('order_id');
			$table->foreign('order_id')
				  ->references('order_id')
				  ->on('agency_orders')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');

			/*
			 * 请求参数
			 *		车牌号码，如粤A12N12
			 */
			$table->char('req_car_plate_no', 8);
			
			/*
			 * 请求参数
			 * 		发动机号码后6位
			 */
			$table->char('req_car_engine_no', 6);
			
			/*
			 * 请求参数
			 * 	 	车架号码后6位
			 */
			$table->string('req_car_frame_no', 6);
			
			/*
			 * 请求结果
			 * 		违章时间
			 */
			$table->datetime('rep_event_time');
			
			/*
			 * 请求结果
			 * 		违章城市
			 */
			$table->string('rep_event_city');
			
			/*
			 * 请求结果
			 * 		违章地点
			 */
			$table->string('rep_event_addr');
			
			/*
			 * 请求结果
			 * 		违章行为描述
			 */
			$table->string('rep_violation_behavior');
			
			/*
			 * 请求结果
			 * 		违章扣分分值
			 */
			$table->integer('rep_point_no')->default(0);
			
			/*
			 * 请求结果
			 * 		违章应罚本金
			 */
			$table->float('rep_priciple_balance')->default(0.00);
			
			/*
			 * 请求结果
			 * 		违章滞纳金
			 */
			$table->float('rep_late_fee')->default(0.00);
			
			/*
			 * 请求结果
			 * 		单笔订单代办服务费
			 * 		需从cheshang_fee_type.number中取值
			 */
			$table->float('rep_service_charge')->default(0.00);

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

		Schema::dropIfExists( 'traffic_violation_info' );
	}
}
