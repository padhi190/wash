<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_name');
            $table->text('q1')->nullable;
            $table->text('q2')->nullable;
            $table->text('q3')->nullable;
            $table->text('q4')->nullable;
            $table->text('q5')->nullable;
            $table->text('q6')->nullable;
            $table->text('q7')->nullable;
            $table->text('q8')->nullable;
            $table->text('q9')->nullable;
            $table->text('q10')->nullable;
            $table->text('essay')->nullable;
            $table->string('no_of_questions');
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
        Schema::dropIfExists('survey_templates');
    }
}
