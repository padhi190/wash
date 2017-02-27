<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487937522TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->softDeletes();
            
        });
Schema::table('tasks', function (Blueprint $table) {
            $table->integer('branch_id')->unsigned()->nullable();
                $table->foreign('branch_id', 'fk_17041_branch_branch_id_task')->references('id')->on('branches')->onDelete('cascade');
                
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
            $table->dropForeign('fk_17041_branch_branch_id_task');
            $table->dropIndex('fk_17041_branch_branch_id_task');
            $table->dropColumn('branch_id');
            
        });
Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            
        });

    }
}
