<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgencyOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::table('agency_orders', function( $table ){

			/*
			 * 车架号码后六位
			 */
			$table->char( 'car_frame_no', 6 );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){

		Schema::table('agency_orders', function( $table ){

			$table->dropColumn( 'car_frame_no' );
		});
	}
}
