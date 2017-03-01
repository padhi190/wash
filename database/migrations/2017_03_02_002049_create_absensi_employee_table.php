<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensiEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('absensi_employee')) {
            Schema::create('absensi_employee', function (Blueprint $table) {
                $table->integer('absensi_id')->unsigned()->nullable();
                $table->foreign('absensi_id', 'fk_p_17172_17171_employee_absensi')->references('id')->on('absensis')->onDelete('cascade');
                $table->integer('employee_id')->unsigned()->nullable();
                $table->foreign('employee_id', 'fk_p_17171_17172_absensi_employee')->references('id')->on('employees')->onDelete('cascade');
                
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
        //
    }
}
