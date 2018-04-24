<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingRewardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_reward', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->unsigned();
            $table->integer('reward_id')->unsigned();
            $table->unique(['booking_id', 'reward_id']);
            $table->double('used_amount');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('reward_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('reward_id')->nullable()->after('gross_revenue');
        });

        Schema::drop('booking_reward');
    }
}
