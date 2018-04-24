<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique(); // Primary email would be here
            $table->string('password');
            $table->boolean('password_is_empty')->default(false);
            $table->boolean('is_active')->default(true);

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', array('male', 'female'))->nullable();
            $table->unsignedInteger('avatar_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->unsignedInteger('country_id')->nullable();

            // OAuth IDs
            $table->string('linkedin_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();


            $table->text('about_me')->nullable();
            $table->date('dob')->nullable();

            // Track user
            // sign_in_count - Increased every time a sign in is made (by form, openid, oauth)
            // current_sign_in_at - A timestamp updated when the user signs in
            // last_sign_in_at - Holds the timestamp of the previous sign in
            $table->unsignedInteger('sign_in_count')->nullable();
            $table->dateTime('current_sign_in_at')->nullable();
            $table->dateTime('last_sign_in_at')->nullable();

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
