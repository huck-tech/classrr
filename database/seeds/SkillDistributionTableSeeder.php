<?php

use App\SkillDistribution;
use Illuminate\Database\Seeder;

class SkillDistributionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') == 'local') {
    	   SkillDistribution::truncate();    		
        }
			
		// Creating skill for account test@airdojo.com
		factory(SkillDistribution::class, 5)->create();
    }
}
