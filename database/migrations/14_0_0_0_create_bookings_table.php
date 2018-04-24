<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid');

            $table->unsignedInteger('student_id');
            $table->unsignedInteger('classroom_id');
            $table->unsignedInteger('tutor_id');
            $table->boolean('tutor_approved');

            $table->float('price');
            $table->float('student_fee')->nullable();
            $table->float('tutor_commission')->nullable();
            $table->float('gross_revenue')->nullable();
            $table->enum('day_time', array('morning','afternoon','evening'))->nullable();
            $table->date('start_date');

            $table->string('payment_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', array('created', 'authorized', 'cancelled', 'pending',
                'in escrow','completed','disputed','refunded'))->nullable();
            //
            $table->string('payment_data')->nullable();

            $table->string('currency_code')->nullable();

            $table->dateTime('student_reviewed_at')->nullable();
            $table->unsignedInteger('student_review')->nullable();
            $table->text('student_comment')->nullable();

            $table->dateTime('tutor_reviewed_at')->nullable();
            $table->unsignedInteger('tutor_review')->nullable();
            $table->text('tutor_comment')->nullable();

            $table->string('payout_method')->nullable();
            $table->text('payout_details')->nullable();
            $table->enum('pricing', array('pending','completed','cancelled'))->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bookings');
    }
}
