<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnTransferSkillInClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('classrooms', 'transfer_skill')) {
            Schema::table('classrooms', function(Blueprint $table) {
                $table->dropColumn('transfer_skill');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(! Schema::hasColumn('classrooms', 'transfer_skill')) {
            Schema::table('classrooms', function (Blueprint $table) {
                $table->integer('transfer_skill')->default(0)->after('enrollment_date');
            });
        }
    }
}
