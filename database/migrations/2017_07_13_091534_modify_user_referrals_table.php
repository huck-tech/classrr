<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_referral_statistics', function (Blueprint $table) {
            $table->dropColumn('pending');
            $table->dropColumn('earned');
            $table->dropColumn('paid');
        });

        Schema::table('user_referral_statistics', function (Blueprint $table) {
            $table->double('pending')->default(0)->after('referrals');
            $table->double('earned')->default(0)->after('pending');
            $table->double('paid')->default(0)->after('earned');
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
            $table->dropColumn('pending');
            $table->dropColumn('earned');
            $table->dropColumn('paid');
        });

        Schema::table('user_referral_statistics', function (Blueprint $table) {
            $table->integer('pending')->default(0)->after('referrals');
            $table->integer('earned')->default(0)->after('pending');
            $table->integer('paid')->default(0)->after('earned');
        });
    }
}
