<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTrafficViolationInfoTableAddColumnRepSequenceNum extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){

		Schema::table('traffic_violation_info', function(Blueprint $table){

			$table->char( 'rep_sequence_num', 64 );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){

		Schema::table('traffic_violation_info', function(Blueprint $table){
			
			$table->dropColumn( 'rep_sequence_num' );
		});
	}
}
