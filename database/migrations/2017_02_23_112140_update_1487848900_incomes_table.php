<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487848900IncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->integer('vehicle_id')->unsigned()->nullable();
                $table->foreign('vehicle_id', 'fk_17048_vehicle_vehicle_id_income')->references('id')->on('vehicles')->onDelete('cascade');
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign('fk_17048_vehicle_vehicle_id_income');
            $table->dropIndex('fk_17048_vehicle_vehicle_id_income');
            $table->dropColumn('vehicle_id');
            
        });

    }
}
