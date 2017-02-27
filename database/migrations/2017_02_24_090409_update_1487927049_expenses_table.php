<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487927049ExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->integer('from_id')->unsigned()->nullable();
                $table->foreign('from_id', 'fk_17127_account_from_id_expense')->references('id')->on('accounts')->onDelete('cascade');
                
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
            $table->dropForeign('fk_17127_account_from_id_expense');
            $table->dropIndex('fk_17127_account_from_id_expense');
            $table->dropColumn('from_id');
            
        });

    }
}
