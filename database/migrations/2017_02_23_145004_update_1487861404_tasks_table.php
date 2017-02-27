<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487861404TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('fk_17031_user_user_id_task');
            $table->dropIndex('fk_17031_user_user_id_task');
            $table->dropColumn('user_id');
            
        });
Schema::table('tasks', function (Blueprint $table) {
            $table->integer('kendaraan_id')->unsigned()->nullable();
                $table->foreign('kendaraan_id', 'fk_17048_vehicle_kendaraan_id_task')->references('id')->on('vehicles')->onDelete('cascade');
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('fk_17048_vehicle_kendaraan_id_task');
            $table->dropIndex('fk_17048_vehicle_kendaraan_id_task');
            $table->dropColumn('kendaraan_id');
            
        });
Schema::table('tasks', function (Blueprint $table) {
                        $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', 'fk_17031_user_user_id_task')->references('id')->on('users')->onDelete('cascade');
                
        });

    }
}
