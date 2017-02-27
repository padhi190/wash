<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487926627ExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->integer('employee_id')->unsigned()->nullable();
                $table->foreign('employee_id', 'fk_17337_employee_employee_id_expense')->references('id')->on('employees')->onDelete('cascade');
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('fk_17337_employee_employee_id_expense');
            $table->dropIndex('fk_17337_employee_employee_id_expense');
            $table->dropColumn('employee_id');
            
        });

    }
}
