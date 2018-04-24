<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('level_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('thumb_path');
            $table->text('description');
            $table->unsignedInteger('number_student');

            // Address
            $table->unsignedInteger('country_id')->nullable();
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code', 20);
            $table->string('lat');
            $table->string('lng');
            $table->text('location_comments')->nullable();


            // Price
            $table->enum('pricing', array('fixed', 'flexible'))->nullable();
            $table->float('base_price');
            $table->float('price_morning')->nullable();
            $table->float('price_afternoon')->nullable();
            $table->float('price_evening')->nullable();
            $table->boolean('add_weekend_fee')->nullable();
            $table->float('price_weekend')->nullable();

            // Schedule
            $table->unsignedInteger('duration_id');
            $table->date('enrollment_date');
            $table->text('schedule');

            //
            $table->boolean('late_signup')->nullable();
            $table->string('language');
            $table->unsignedInteger('cancellation_policy')->nullable();
            $table->boolean('is_guaranteed')->nullable();
            $table->boolean('is_international')->nullable();
            $table->string('age_range');
            $table->string('associated_tutors')->nullable();

            $table->float('rating_value')->nullable();
            $table->unsignedInteger('rating_votes')->nullable();

            // Associated tutors many-to-many relation

            // Misc.
            $table->text('rules');



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
        Schema::drop('classrooms');
    }
}
