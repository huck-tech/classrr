<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'skill_points'   => 15,
        'password'       => bcrypt('123456'),
        'about_me'       => $faker->realText(250, 1),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Classroom::class, function (Faker\Generator $faker) {
    $p = ['fixed', 'flexible'];
    $pricing = $p[array_rand($p)];
    $title = $faker->realText(30, 1);
    $slug = str_slug($title);

    return [
        "user_id" => \App\User::inRandomOrder()->first()->id,
        "category_id" => \App\Category::inRandomOrder()->first()->id,
        "level_id" => \App\ClassroomLevel::inRandomOrder()->first()->id,
        "title" => $title,
        "slug" => $slug,
        "description" => $faker->realText(250, 1),
        "location_comments" => $faker->realText(250, 1),
        "number_student" => rand(1, 6),
        "country_id" => \App\Country::inRandomOrder()->first()->id,
        "address_1" => $faker->streetName(30, 1),
        "address_2" => $faker->streetAddress(30, 1),
        "city" => $faker->city(),
        "state" => $faker->state(),
        "zip_code" => $faker->postcode(),
        "lat" => $faker->latitude(),
        "lng" => $faker->longitude(),
        "pricing" => $pricing,
        "base_price" => rand(8,30),
        "price_morning" => $pricing != 'fixed' ? rand(1, 5) : null,
        "price_afternoon" => $pricing != 'fixed' ? rand(1, 5) : null,
        "price_evening" => $pricing != 'fixed' ? rand(1, 5) : null,
        "price_weekend" => $pricing != 'fixed' ? rand(1, 10) : null,
        "duration_id" => \App\ClassroomDuration::inRandomOrder()->first()->id,
        //"enrollment_date" => $faker->dateTimeBetween('+30 days', '+2 years'),
        "enrollment_date" => $faker->dateTimeBetween('+30 days', '+2 years')->format(config('app.dateformat_php')),
        "schedule" => [
            'mon' => [8,9,13,14,19,20],
            'wed' => [8,9,13,14,19,20],
            'fri' => [8,9,13,14,19,20],
        ],
        "language" => $faker->languageCode(),
        "cancellation_policy" => rand(1,3),
        "is_guaranteed" => rand(0,1),
        "is_international" => rand(0,1),
        "late_signup" => rand(0,1),
        //"advanced_booking" => $faker->realText(50, 1),
        "rules" => $faker->sentences(rand(5,7)),
        "age_range" => rand(13,21) . ' - ' . rand(22, 88),
    ];
});

$factory->define(App\Lecture::class, function (Faker\Generator $faker) {
    return [
        "title" => $faker->realText(30, 1),
        "description" => $faker->realText(250, 1),
        "duration" => rand(30,120),
        "order" => rand(1,1000),
    ];
});

$factory->define(App\Review::class, function (Faker\Generator $faker) {
    return [
        "type" => "classroom",
        "user_id" => \App\User::inRandomOrder()->first()->id,
        "comment" => $faker->realText(250, 1),
        "rating" => rand(5,10)
    ];
});


$factory->define(App\Skill::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'icon' => 'icon_set_1_icon-'. $faker->numberBetween(1, 60),
        'slug' => $faker->slug,
        'description' => $faker->realText(250, 1),
        'category_id' => $faker->numberBetween(1,7),
        'max_level' => $faker->numberBetween(1,5),
    ];
});


$factory->define(App\SkillSuggestion::class, function (Faker\Generator $faker) {
    return [        
        'user_id'    => $faker->numberBetween(1, 6),
        'skill_name' => $faker->word,        
    ];
});

$factory->define(App\SkillClassroom::class, function (Faker\Generator $faker) {
    $skill = App\Skill::inRandomOrder()->first();
    return [        
        'skill_id'     => $skill->id,
        'classroom_id' => App\Classroom::inRandomOrder()->first()->id,
        'detail'       =>  $faker->numberBetween(1,4) . 'Point for skill' . $skill->name,
        'related_booking_id' => $faker->numberBetween(1,5),
    ];
});


$factory->define(App\SkillDistribution::class, function (Faker\Generator $faker) {
    $skill     = App\Skill::inRandomOrder()->first();
    $skillName = $skill->name;
    $name      = 'test@airdojo';    
    $minPoint  = 1;
    $maxPoint  = 5;
    $amount    =  $faker->numberBetween($minPoint, $maxPoint);
    $detail    = "$amount $skillName points for $name";

    return [        
        'user_id'            => 1,
        'skill_id'           => $skill->id,
        'detail'             => $detail,
        'amount_point'       => $amount,
        'history_log'       => 'seeder factory',
    ];
});

$factory->define(App\Booking::class, function (Faker\Generator $faker) {  

    $paymentStatus = ['created','authorized','cancelled','pending','in escrow','completed','disputed','refunded','escalated',
    'class_in_progress'];

    $student   = App\User::all()->pluck('id')->toArray();
    $studentId = $faker->randomElement($student);

    $classroom = App\Classroom::all()->pluck('id')->toArray();
    $teacher   = App\User::where('id', '!=', $studentId)->pluck('id')->toArray();
    $dayTimes  = [ 'morning', 'afternoon', 'evening'];
    $now       =  Carbon::now();    

    return [        
        'student_id'          => $studentId,
        'classroom_id'        => $faker->randomElement($classroom),
        'tutor_id'            => $faker->randomElement($teacher),
        'tutor_approved'      => 1,
        'price'               => $faker->randomNumber(2),
        'student_fee'         => $faker->randomNumber(2),
        'tutor_commission'    => $faker->randomNumber(2),
        'gross_revenue'       => $faker->randomNumber(2),
        'day_time'            => $dayTimes[$faker->numberBetween(0,2)],
        'start_date'          => $now->copy()->subDays($faker->numberBetween(1,120)),
        'payment_id'          => $faker->numberBetween(1,20),
        'payment_method'      => $faker->randomElement(['vcc','bank transfer','paypal','bitcoin']),
        'payment_status'      => $faker->randomElement($paymentStatus),
        'payment_data'        => $faker->bankAccountNumber,
        'currency_code'       => $faker->randomElement(['IDR','USD','SGD','MYR']),
        'student_reviewed_at' => $now->copy()->subDays($faker->numberBetween(1,20)),
        'student_review'      => $faker->word,
        'student_comment'     => $faker->word,
        'tutor_reviewed_at'   => $now->copy()->subDays($faker->numberBetween(1,20)),
        'tutor_review'        => $faker->word,
        'tutor_comment'       => $faker->word,
        'payout_method'       => $faker->word,
        'payout_details'      => $faker->word,
        'pricing'             => $faker->randomElement(['pending','completed','cancelled']),
        'cancelled_reason'    => $faker->sentence(5),
        'tutor_report'        => $faker->sentence(5) ,
        'student_report'      => $faker->sentence(5),
    ];
});

$factory->state(App\Booking::class, 'completed', function(Faker\Generator $faker) {        
    return [
        'uid'               => sha1(time()),
        'payment_status' => 'completed',
    ];
});

$factory->state(App\Classroom::class, 'in30', function(Faker\Generator $faker) {
    // App\Classroom::dontSyncDocument();
    $now = Carbon::now();    
    return [
        'enrollment_date' => $now->copy()->subDays($faker->numberBetween(1,30))->format('Y-m-d'),
    ];
});

$factory->state(App\Classroom::class,'in60', function(Faker\Generator $faker) {
    // App\Classroom::dontSyncDocument();
    $now = Carbon::now();
    return [
        'enrollment_date' => $now->copy()->subDays($faker->numberBetween(31, 60))->format('Y-m-d'),
    ];
});

$factory->define(App\SkillClassroom::class, function(Faker\Generator $faker) {
    // App\Classroom::dontSyncDocument();
    $skill     = App\Skill::inRandomOrder()->first()->id;
    $classroom = App\Classroom::inRandomOrder()->first()->id;
    $booking   = App\Booking::inRandomOrder()->first()->id;

    return [
        'skill_id'           => $skill,
        'classroom_id'       => $classroom,
        'detail'             => $classroom.' skills',
        'amount_point'       => 1,
        'related_booking_id' => $booking,
    ];
});