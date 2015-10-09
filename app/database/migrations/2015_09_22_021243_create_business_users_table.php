<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'business_users', function( $table ){

			/*
			 * 用户id
			 * 		同时作为主键和外键
			 * 		外键约束：users表user_id字段
			 */
			$table->string('user_id');
			$table->primary('user_id');
			$table->foreign('user_id')
				  ->references('user_id')
				  ->on('users')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');

			/*
			 * 账户余额
			 */
			$table->float('balance')->default(0.00);

			/*
			 * 通过api查询所需key
			 */ 
			$table->char('app_key', 36)->nullable();

			/*
			 * 通过api查询 
			 */
			$table->char('app_secret', 36)->nullable();

			/*
			 * 企业名称
			 */
			$table->string('business_name')->nullable();

			/*
			 * 15位企业营业执照号或18位的统一社会信用代码
			 */ 
			$table->string('business_licence_no', 18)->nullable();

			/*
			 * 营业执照扫描件存放位置
			 */
			$table->string('business_licence_scan_path')->nullable();

			/*
			 * 运营人员姓名
			 */
			$table->string('operational_name')->nullable();

			/*
			 * 运营人员身份证号码
			 */
			$table->char('operational_card_no', 18)->nullable();

			/*
			 * 运营人员手机号码
			 */
			$table->char('operational_phone', 11)->nullable();

			/*
			 * 企业银行账号
			 */
			$table->string('bank_account')->nullable();

			/*
			 * 开户银行
			 */
			$table->string('deposit_bank')->nullable();

			/*
			 * 开户网点
			 */
			$table->string('bank_outlets')->nullable();

			/*
			 * 运营人员身份证正面扫描件存放位置
			 */
			$table->string('id_card_front_scan_path')->nullable();

			/*
			 * 运营人员身份证背面扫描件存放位置
			 */
			$table->string('id_card_back_scan_path')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){

		Schema::dropIfExists( 'business_users' );
	}
}
