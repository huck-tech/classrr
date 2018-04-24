<?php

use App\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(env('APP_ENV') == 'local') {
            Booking::truncate();
        }
        
    }
}
