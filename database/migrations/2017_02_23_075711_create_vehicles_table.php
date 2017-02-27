<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('license_plate')->nullable();
                $table->integer('customer_id')->unsigned()->nullable();
                $table->foreign('customer_id', 'fk_17043_customer_customer_id_vehicle')->references('id')->on('customers')->onDelete('cascade');
                $table->string('type')->nullable();
                $table->string('brand')->nullable();
                $table->string('model')->nullable();
                $table->string('color')->nullable();
                $table->string('size')->nullable();
                $table->text('note')->nullable();
                
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
        Schema::dropIfExists('vehicles');
    }
}
