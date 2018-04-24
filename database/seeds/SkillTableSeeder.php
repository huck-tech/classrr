<?php

use App\Category;
use App\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillTableSeeder extends Seeder
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
    	    Skill::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        $storage = database_path('15k-skills.sql');
        if(file_exists($storage)) {
            DB::unprepared(file_get_contents($storage));
            $this->command->info('Skill table seeded');
        }
        // factory(App\Skill::class, 100)->create();
    }
}
