<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotGoalSecretaryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goal_secretary', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('goal_id')->unsigned()->index();
			$table->integer('secretary_id')->unsigned()->index();
			$table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
			$table->foreign('secretary_id')->references('id')->on('secretaries')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goal_secretary');
	}

}
