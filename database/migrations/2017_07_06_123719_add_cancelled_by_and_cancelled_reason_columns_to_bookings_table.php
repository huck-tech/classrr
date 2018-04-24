<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelledByAndCancelledReasonColumnsToBookingsTable extends Migration
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
                'pending','in escrow','completed','disputed','refunded', 'escalated')");

        Schema::table('bookings', function (Blueprint $table) {
            $table->text('cancelled_reason')->nullable()->after('pricing');
            $table->text('tutor_report')->nullable()->after('cancelled_reason');
            $table->text('student_report')->nullable()->after('tutor_report');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE bookings MODIFY payment_status ENUM('created', 'authorized', 'cancelled',
                'pending','in escrow','completed','disputed','refunded')");

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('cancelled_reason');
            $table->dropColumn('tutor_report');
            $table->dropColumn('student_report');
        });
    }
}
