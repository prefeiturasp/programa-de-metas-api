<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotPrefectureProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prefecture_project', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('prefecture_id')->unsigned()->index();
			$table->integer('project_id')->unsigned()->index();
			$table->foreign('prefecture_id')->references('id')->on('prefectures')->onDelete('cascade');
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prefecture_project');
	}

}
