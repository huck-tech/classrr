<?php

use App\SkillSuggestion;
use Illuminate\Database\Seeder;

class SkillSuggestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(env('APP_ENV') == 'local' ) {
            SkillSuggestion::truncate();
        }
        
        factory(SkillSuggestion::class, 50)->create();
    }
}
