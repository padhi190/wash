<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487852528IncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->integer('payment_type_id')->unsigned()->nullable();
                $table->foreign('payment_type_id', 'fk_17127_account_payment_type_id_income')->references('id')->on('accounts')->onDelete('cascade');
                
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
            $table->dropForeign('fk_17127_account_payment_type_id_income');
            $table->dropIndex('fk_17127_account_payment_type_id_income');
            $table->dropColumn('payment_type_id');
            
        });

    }
}
