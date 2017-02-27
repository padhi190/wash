<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487859902IncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->softDeletes();
            
        });
Schema::table('incomes', function (Blueprint $table) {
            $table->datetime('date')->nullable();
                
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
            $table->dropColumn('date');
            
        });
Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            
        });

    }
}
