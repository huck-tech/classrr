<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') == 'local') {
            Category::truncate();
        }

        // DB::table('categories')->insert([
        //     ['slug' => 'language', 'name' => 'Language', 'is_active' => true],
        //     ['slug' => 'academics', 'name' => 'Academics', 'is_active' => true],
        //     ['slug' => 'music', 'name' => 'Music', 'is_active' => true],
        //     ['slug' => 'health', 'name' => 'Health & Fitness', 'is_active' => true],
        //     ['slug' => 'photography', 'name' => 'Photography', 'is_active' => true],
        //     ['slug' => 'lifestyle', 'name' => 'Lifestyle', 'is_active' => true],
        //     ['slug' => 'marketing', 'name' => 'Marketing', 'is_active' => true],
        //     ['slug' => 'design', 'name' => 'Design', 'is_active' => true],
        // ]);

        $storage = database_path('categories.sql');
        if(file_exists($storage)) {
            DB::unprepared(file_get_contents($storage));
            $this->command->info('Categories table seeded');
        }
    }
}
