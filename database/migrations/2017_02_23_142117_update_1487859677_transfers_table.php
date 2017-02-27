<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487859677TransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->integer('dari_id')->unsigned()->nullable();
                $table->foreign('dari_id', 'fk_17127_account_dari_id_transfer')->references('id')->on('accounts')->onDelete('cascade');
                $table->integer('ke_id')->unsigned()->nullable();
                $table->foreign('ke_id', 'fk_17127_account_ke_id_transfer')->references('id')->on('accounts')->onDelete('cascade');
                $table->text('note')->nullable();
                
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
            $table->dropForeign('fk_17127_account_dari_id_transfer');
            $table->dropIndex('fk_17127_account_dari_id_transfer');
            $table->dropColumn('dari_id');
            $table->dropForeign('fk_17127_account_ke_id_transfer');
            $table->dropIndex('fk_17127_account_ke_id_transfer');
            $table->dropColumn('ke_id');
            $table->dropColumn('note');
            
        });

    }
}
