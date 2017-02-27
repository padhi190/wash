<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('absensis')) {
            Schema::create('absensis', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('branch_id')->unsigned()->nullable();
                $table->foreign('branch_id', 'fk_17041_branch_branch_id_absensi')->references('id')->on('branches')->onDelete('cascade');
                $table->date('tanggal')->nullable();
                $table->integer('karyawan_id')->unsigned()->nullable();
                $table->foreign('karyawan_id', 'fk_17337_employee_karyawan_id_absensi')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('absensis');
    }
}
