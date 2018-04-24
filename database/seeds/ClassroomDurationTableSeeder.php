<?php

use App\ClassroomDuration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomDurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') == 'local') {
            ClassroomDuration::truncate();
        }

        DB::table('classroom_durations')->insert([
            ['days' => 30, 'title' => '1 Month', 'is_active' => true],
            ['days' => 90, 'title' => '3 Month', 'is_active' => true],
            ['days' => 180, 'title' => '6 Month', 'is_active' => false]
        ]);
    }
}
