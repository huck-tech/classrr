<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_distributions', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('skill_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();            

            $table->text('detail');
            $table->integer('amount_point');
            $table->string('related_booking_id')->nullable();
            $table->timestamps();

            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_distributions');
    }
}
