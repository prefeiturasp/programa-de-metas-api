<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('goal_id')->unsigned()->index();
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
            $table->integer('project_type')->index();
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->string('gps_lat');
            $table->string('gps_long');
            $table->decimal('weight_about_goal',15,2);
            $table->decimal('budget_executed',15,2)->nullable();
            $table->text('qualitative_progress_1')->nullable();
            $table->text('qualitative_progress_2')->nullable();
            $table->text('qualitative_progress_3')->nullable();
            $table->text('qualitative_progress_4')->nullable();
            $table->text('qualitative_progress_5')->nullable();
            $table->text('qualitative_progress_6')->nullable();
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
        Schema::drop('projects');
    }

}
