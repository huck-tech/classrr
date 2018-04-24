<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserReferralStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_referral_statistics', function (Blueprint $table) {
            $table->dropColumn('paid');
        });

        Schema::table('user_referral_statistics', function (Blueprint $table) {
            $table->double('approved')->default(0)->after('earned');
            $table->double('used')->default(0)->after('approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_referral_statistics', function (Blueprint $table) {
            $table->dropColumn('approved');
            $table->dropColumn('used');
        });

        Schema::table('user_referral_statistics', function (Blueprint $table) {
            $table->integer('paid')->default(0)->after('earned');
        });
    }
}
