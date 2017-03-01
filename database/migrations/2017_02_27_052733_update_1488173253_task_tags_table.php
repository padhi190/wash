<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1488173253TaskTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_tags', function (Blueprint $table) {
            $table->softDeletes();
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_tags', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            
        });

    }
}