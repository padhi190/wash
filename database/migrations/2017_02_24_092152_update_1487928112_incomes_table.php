<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487928112IncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('date');
            
        });
Schema::table('incomes', function (Blueprint $table) {
            $table->datetime('entry_date')->nullable();
                
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
            $table->dropColumn('entry_date');
            
        });
Schema::table('incomes', function (Blueprint $table) {
                        $table->datetime('date')->nullable();
                
        });

    }
}
