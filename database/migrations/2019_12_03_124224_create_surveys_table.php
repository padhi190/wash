<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('income_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('template_id')->unsigned();
            $table->foreign('income_id')->references('id')->on('incomes');
            $table->string('q1')->nullable;
            $table->string('q2')->nullable;
            $table->string('q3')->nullable;
            $table->string('q4')->nullable;
            $table->string('q5')->nullable;
            $table->string('q6')->nullable;
            $table->string('q7')->nullable;
            $table->string('q8')->nullable;
            $table->string('q9')->nullable;
            $table->string('q10')->nullable;
            $table->text('essay')->nullable;
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
        Schema::dropIfExists('surveys');
    }
}
