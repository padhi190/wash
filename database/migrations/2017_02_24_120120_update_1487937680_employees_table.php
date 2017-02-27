<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487937680EmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('branch_id')->unsigned()->nullable();
                $table->foreign('branch_id', 'fk_17041_branch_branch_id_employee')->references('id')->on('branches')->onDelete('cascade');
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('fk_17041_branch_branch_id_employee');
            $table->dropIndex('fk_17041_branch_branch_id_employee');
            $table->dropColumn('branch_id');
            
        });

    }
}
