<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487982024IncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->nullable();
                $table->foreign('product_id', 'fk_17462_product_product_id_income')->references('id')->on('products')->onDelete('cascade');
                
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
            $table->dropForeign('fk_17462_product_product_id_income');
            $table->dropIndex('fk_17462_product_product_id_income');
            $table->dropColumn('product_id');
            
        });

    }
}
