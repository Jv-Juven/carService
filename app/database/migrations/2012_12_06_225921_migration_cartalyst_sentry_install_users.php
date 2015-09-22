	<?php
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Database\Migrations\Migration;

class MigrationCartalystSentryInstallUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::create('users', function($table){

			/*
		     * 用户id
		     *		作为主键
		     *		生成：
		     * 			'yhxx' + uniqid()
		     * 			共 4 + 13 = 17位
			 */ 
			$table->string('user_id');
			$table->primary('user_id');

			/*
			 * 登陆账号
			 * 		个人用户为手机
			 * 		企业用户为邮箱
			 */ 
			$table->string('login_account');
			$table->unique('login_account');

			/*
			 * 密码
			 * 		6 - 16位，字母数字下划线组成
			 */ 
			$table->string('password');

			/*
		     * 状态: 
		     * 		10 : 未激活邮箱
		     *		11 : 未登记信息
		     *		20 : 信息审核中
		     *		21 : 等待用户校验激活
		     * 		22 : 激活
		     * 		30 : 账号锁定
			 */
			$table->string('status')->default('10');

			/*
			 * 用户类型
			 * 		0  : 个人用户
			 * 		1  : 企业用户
			 */
			$table->integer('user_type')->default(0);

			/*
			 * 打款备注码
			 * 		运营人员通过管理后台录入
			 */ 
			$table->string('remark_code')->nullable();
			
			/*
			 * 添加created_at和updated_at
			 */
			$table->timestamps();

			$table->text('permissions')->nullable();
			$table->boolean('activated')->default(1);
			$table->string('activation_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('persist_code')->nullable();
			$table->string('reset_password_code')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';

			$table->index('activation_code');
			$table->index('reset_password_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		
		Schema::dropIfExists('users');
	}

}
