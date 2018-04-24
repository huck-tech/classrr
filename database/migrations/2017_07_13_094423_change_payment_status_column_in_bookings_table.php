<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePaymentStatusColumnInBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Using DB instead of schema because we need doctrine/dbal for changing column
        // and and we couldn't add it because of some conflicts
        DB::statement("ALTER TABLE bookings MODIFY payment_status ENUM('created', 'authorized', 'cancelled',
                'pending','in escrow','completed','disputed','refunded', 'escalated', 'class_in_progress')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE bookings MODIFY payment_status ENUM('created', 'authorized', 'cancelled',
                'pending','in escrow','completed','disputed','refunded', 'escalated')");
    }
}
