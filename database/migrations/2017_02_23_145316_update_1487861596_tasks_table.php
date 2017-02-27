<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1487861596TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('attachment');
            
        });
Schema::table('tasks', function (Blueprint $table) {
            $table->datetime('entry_date')->nullable();
                $table->datetime('approval_date')->nullable();
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('entry_date');
            $table->dropColumn('approval_date');
            
        });
Schema::table('tasks', function (Blueprint $table) {
                        $table->string('name')->nullable();
                $table->string('attachment')->nullable();
                
        });

    }
}
