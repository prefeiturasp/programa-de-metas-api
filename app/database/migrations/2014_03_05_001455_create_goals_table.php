<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('objective_id')->unsigned()->index();
            $table->integer('axis_id')->unsigned()->index();
            $table->integer('articulation_id')->unsigned()->index();

            $table->foreign('objective_id')->references('id')->on('objectives')->onDelete('cascade');
            $table->foreign('axis_id')->references('id')->on('axes')->onDelete('cascade');
            $table->foreign('articulation_id')->references('id')->on('articulations')->onDelete('cascade');

            $table->string('name', 350)->index();
            $table->text('will_be_delivered');
            $table->decimal('total_cost',15,2);
            $table->text('schedule_2013_2014');
            $table->text('schedule_2015_2016');
            $table->text('observation');
            $table->text('technically');
            $table->integer('status');
            $table->text('transversalidade')->nullable();
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
        Schema::drop('goals');
    }

}
