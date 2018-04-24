<?php

use App\SkillClassroom;
use Illuminate\Database\Seeder;

class SkillClassroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') == 'local') {
            SkillClassroom::truncate();
        }

        factory(App\SkillClassroom::class, 5)->create();
    }
}
