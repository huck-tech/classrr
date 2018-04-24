<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    	
        $exist = User::where('email', 'test@airdojo.com')->first();
        if(!$exist) {
            DB::table('users')->insert([
            	'first_name' => 'John', 'last_name' => 'Test', 'email' => 'test@airdojo.com', 'password' => bcrypt('123456'),
                'skill_points' => 15,
            ]);


            DB::table('users')->insert([
                'first_name' => 'John',
                'last_name' => 'Tutor',
                'email' => 'tutor@airdojo.com',
                'password' => bcrypt('123456'),
                'skill_points' => 15,
            ]);
            
            DB::table('users')->insert([
                'first_name' => 'John',
                'last_name' => 'Student',
                'email' => 'student@airdojo.com',
                'password' => bcrypt('123456'),
                'skill_points' => 15,
            ]);
        }

        factory(App\User::class, 5)->create();

    }
}
