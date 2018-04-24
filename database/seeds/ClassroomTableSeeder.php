<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_classroom = factory(App\Classroom::class)->make();
        $first_classroom->user_id = 1;
        $first_classroom->save();
        $tmp = $first_classroom->getEnrollmentDates();
        $tmp2 = array_keys($tmp);
        $first_enrollment = array_shift($tmp2);

        $second_classroom = factory(App\Classroom::class)->make();
        $second_classroom->user_id = 2;
        $second_classroom->save();
        $tmp = $second_classroom->getEnrollmentDates();
        $tmp2 = array_keys($tmp);
        $second_enrollment = array_shift($tmp2);


        factory(App\Classroom::class, 32)->create()->each(function($cl) {
           for ($i = 0; $i < rand(3,6); $i++) {
               $curr = factory(App\Lecture::class)->make();
               $curr->classroom_id = $cl->id;
               $curr->save();

               $review = factory(App\Review::class)->make();
               $review['object_id'] = $cl->id;
               $review->save();
           }
        });

        DB::table('bookings')->insert([
            ['uid' => uniqid(), 'tutor_id' => 1, 'student_id' => 4, 'classroom_id' => $first_classroom->id, 'tutor_approved' => 1, 'price' => 1, 'day_time' => 'morning', 'start_date' => $first_enrollment],
            ['uid' => uniqid(), 'tutor_id' => 1, 'student_id' => 5, 'classroom_id' => $first_classroom->id, 'tutor_approved' => 1, 'price' => 1, 'day_time' => 'morning', 'start_date' => $first_enrollment],
            ['uid' => uniqid(), 'tutor_id' => 1, 'student_id' => 6, 'classroom_id' => $first_classroom->id, 'tutor_approved' => 1, 'price' => 1, 'day_time' => 'morning', 'start_date' => $first_enrollment],
            ['uid' => uniqid(), 'tutor_id' => 1, 'student_id' => 7, 'classroom_id' => $first_classroom->id, 'tutor_approved' => 1, 'price' => 1, 'day_time' => 'afternoon', 'start_date' => $first_enrollment],
            ['uid' => uniqid(), 'tutor_id' => 1, 'student_id' => 8, 'classroom_id' => $first_classroom->id, 'tutor_approved' => 1, 'price' => 1, 'day_time' => 'evening', 'start_date' => $first_enrollment],
            ['uid' => uniqid(), 'tutor_id' => 2, 'student_id' => 1, 'classroom_id' => $second_classroom->id, 'tutor_approved' => 1, 'price' => 1, 'day_time' => 'morning', 'start_date' => $second_enrollment],
        ]);
    }
}
