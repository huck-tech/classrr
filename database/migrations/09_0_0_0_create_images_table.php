<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');

            $table->unsignedInteger('file_size');
            $table->string('original_name');
            $table->string('name');
            $table->string('path');
            $table->string('storage');
            $table->string('image_type');
            $table->string('file_type', 8);
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');


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
        Schema::drop('images');
    }
}
