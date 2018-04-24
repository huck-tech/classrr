<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    protected $production = [
        ClassroomLevelTableSeeder::class,
        ClassroomDurationTableSeeder::class,
        CategoriesTableSeeder::class,
        CountriesTableSeeder::class,

        SkillTableSeeder::class,
    ];

    protected $local = [
        ClassroomLevelTableSeeder::class,
        ClassroomDurationTableSeeder::class,
        CategoriesTableSeeder::class,
        CountriesTableSeeder::class,
        
        UserTableSeeder::class,
        ClassroomTableSeeder::class,        
        SkillTableSeeder::class,
        SkillSuggestionTableSeeder::class,
        SkillDistributionTableSeeder::class,
        SkillClassroomTableSeeder::class,        
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Call Production seeder        
            
        if(env('APP_ENV') == 'production') {
            foreach($this->production as $seed) {
                $this->call($seed);
                $this->command->info("$seed has been added");
            }
        }       
        // End production seeds


//        factory(App\User::class, 10)->create()->each(function ($u) {
//            $u->posts()->save(factory(App\Post::class)->make());
//        });
        if(env('APP_ENV') == 'local') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            foreach($this->local as $seed) {
                $this->call($seed);
                $this->command->info("$seed has been added");
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }      

    }
}
