<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArchivedByAndArchivedReasonToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('archived_by')->nullable()->after('messageable_type');
            $table->string('archived_reason')->nullable()->after('archived_by');
            $table->timestamp('archived_at')->nullable()->after('archived_reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('archived_by');
            $table->dropColumn('archived_reason');
            $table->dropColumn('archived_at');
        });
    }
}
