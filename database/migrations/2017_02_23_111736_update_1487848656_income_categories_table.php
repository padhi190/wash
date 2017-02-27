<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487848656IncomeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_categories', function (Blueprint $table) {
            $table->integer('harga')->nullable()->unsigned();
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_categories', function (Blueprint $table) {
            $table->dropColumn('harga');
            
        });

    }
}
