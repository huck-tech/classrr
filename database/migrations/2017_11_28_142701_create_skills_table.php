<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('category_id')->nullable()->default(0);
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->integer('max_level');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('skills');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
