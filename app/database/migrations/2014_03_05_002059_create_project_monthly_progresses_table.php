<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectMonthlyProgressesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_monthly_progresses', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('prefecture_id')->unsigned()->index();
            $table->foreign('prefecture_id')->references('id')->on('prefectures')->onDelete('cascade');
            $table->integer('goal_target')->nullable();
            $table->datetime('month_year');
            $table->integer('value')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_monthly_progresses');
    }

}
