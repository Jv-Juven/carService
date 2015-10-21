<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTrafficViolationInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		if ( !Schema::hasColumn( 'traffic_violation_info', 'rep_event_city' ) ){

			Schema::table('traffic_violation_info', function(Blueprint $table){

				$table->string( 'rep_event_city' );
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){

		if ( Schema::hasColumn( 'traffic_violation_info', 'rep_event_city' ) ){
			
			Schema::table('traffic_violation_info', function(Blueprint $table){

				$table->dropColumn( 'rep_event_city' );
			});
		}
	}
}
