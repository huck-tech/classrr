<?php

use App\Booking;
use App\Classroom;
use App\Skill;
use App\SkillClassroom;
use App\SkillDistribution;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') == 'local') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            User::truncate();
            SkillDistribution::truncate();
            Classroom::truncate();
            SkillClassroom::truncate();
            Booking::truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        factory(App\User::class, 10)->create();
        /*
         * Create 5 Classroom, each has 5 random skills at least
         */
        factory(App\Classroom::class, 5)->states('in30')->create();
        factory(App\Classroom::class, 5)->states('in60')->create();
        // factory(App\Booking::class, 5)->states('completed')->create();
        
        /**
         * Give 5 skills for each existing classroom
         */
        $classroom =  App\Classroom::all();

        if($classroom) {
            foreach($classroom as $class) {
                $randomSkills = App\Skill::inRandomOrder()->limit(5)->get()->pluck('id');
                $skills       = [];                

                if($randomSkills) {
                    foreach($randomSkills as $skill) {
                        $skills[$skill] = ['amount_point' => 1];
                    }
                }                
                
                $class->skills()->sync($skills, true);                
            }
        }    


        /**
         * Creating booking data         
         */
        
        for($i=1; $i<=2; $i++) {
            $getClassroom = App\Classroom::inRandomOrder()->first(); 
            $getTutor = App\User::inRandomOrder()->first();          

            $getStudent = App\User::where('id', '!=', $getTutor->id)->limit(5)->get();          

            foreach($getStudent as $student) {
                $input = [
                    'uid'            => uniqid(), 
                    'tutor_id'       => $getTutor->id, 
                    'student_id'     => $student->id, 
                    'classroom_id'   => $getClassroom->id, 
                    'tutor_approved' => 1, 
                    'price'          => array_rand([10,15,20]), 
                    'day_time'       => array_rand(['morning','afternoon','evening']), 
                    'payment_status' => 'completed', 
                ];


                App\Booking::create($input);
            }
        }
    }
}
