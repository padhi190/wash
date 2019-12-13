<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponDetailsToSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('surveys', function (Blueprint $table) {
            $table->string('coupon_code')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('coupon_type')->nullable();

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
         Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('coupon_code');
            $table->dropColumn('expiry_date');
            $table->dropColumn('coupon_type');
            
        });
    }
}
