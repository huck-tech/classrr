<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHistoryLogIntoSkillDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('skill_distributions', 'related_booking_id')) {
            Schema::table('skill_distributions', function (Blueprint $table) {                
                $table->dropColumn('related_booking_id');
            });
        }

        Schema::table('skill_distributions', function (Blueprint $table) {
            $table->text('history_log')->after('amount_point')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skill_distributions', function (Blueprint $table) {
            $table->dropColumn('history_log');
        });

        if (! Schema::hasColumn('skill_distributions', 'related_booking_id')) {
            Schema::table('skill_distributions', function (Blueprint $table) {                
                $table->integer('related_booking_id')->after('amount_point')->nullable();
            });
        }
    }
}
