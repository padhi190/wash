<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsSettingsToBranches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('branches', function (Blueprint $table) {
            $table->string('sms_url')->nullable();
            $table->boolean('sms_on')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('sms_url');
            $table->dropColumn('sms_on');
            
        });
    }
}
