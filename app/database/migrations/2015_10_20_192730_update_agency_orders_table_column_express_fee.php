<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgencyOrdersTableColumnExpressFee extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		DB::statement( 'alter table agency_orders modify express_fee float(8, 2) default 0.00' );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		
	}
}
