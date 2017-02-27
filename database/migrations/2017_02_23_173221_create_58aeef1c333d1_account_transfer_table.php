<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create58aeef1c333d1AccountTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('account_transfer')) {
            Schema::create('account_transfer', function (Blueprint $table) {
                $table->integer('account_id')->unsigned()->nullable();
                $table->foreign('account_id', 'fk_p_17127_17157_transfer_account')->references('id')->on('accounts')->onDelete('cascade');
                $table->integer('transfer_id')->unsigned()->nullable();
                $table->foreign('transfer_id', 'fk_p_17157_17127_account_transfer')->references('id')->on('transfers')->onDelete('cascade');
                
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
        Schema::dropIfExists('account_transfer');
    }
}
