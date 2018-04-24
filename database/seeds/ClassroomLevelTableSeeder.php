<?php

use App\ClassroomLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') == 'local') {
            // ClassroomLevel::truncate();
        }

        DB::table('classroom_levels')->insert([
            ['slug' => 'beginner', 'title' => 'Beginner', 'rank' => '1'],
            ['slug' => 'intermediate', 'title' => 'Intermediate', 'rank' => '2'],
            ['slug' => 'advanced', 'title' => 'Advanced', 'rank' => '3'],
        ]);
    }
}
