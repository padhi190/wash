<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487937402TransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->integer('branch_id')->unsigned()->nullable();
                $table->foreign('branch_id', 'fk_17041_branch_branch_id_transfer')->references('id')->on('branches')->onDelete('cascade');
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('fk_17041_branch_branch_id_transfer');
            $table->dropIndex('fk_17041_branch_branch_id_transfer');
            $table->dropColumn('branch_id');
            
        });

    }
}
