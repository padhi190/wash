<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->enum('gender', ["Laki-laki","Perempuan"])->nullable();
                $table->string('phone')->nullable();
                $table->date('join_date')->nullable();
                $table->text('note')->nullable();
                $table->integer('branch_id')->unsigned()->nullable();
                $table->foreign('branch_id', 'fk_17041_branch_branch_id_customer')->references('id')->on('branches')->onDelete('cascade');
                
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
