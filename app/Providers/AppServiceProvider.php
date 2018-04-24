<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Global view variables
        // Read more: http://laraveldaily.com/global-variables-in-base-controller/
        view()->composer('*',function($view) {
            //region Main Search bar "When?" options
                $current_month = date('n');
                $current_year = date('Y');
                $next_year = $current_year + 1;

                $range_of_month = [];
                $select_options = [];
                $month_array = [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October',
                    'November', 'December'
                ];
                for ($i = $current_month; $i <= 12; $i++) {
                    $range_of_month[$current_year . '-' . sprintf('%02d', $i)] = $month_array[$i-1] . ', ' . $current_year;
                }
                for ($i = 1; $i < $current_month; $i++) {
                    $range_of_month[$next_year . '-' . sprintf('%02d', $i)] = $month_array[$i-1] . ', ' . $next_year;
                }
                $view->with('search_month_select', $range_of_month);
            //endregion

            //region Duration
                //TODO: Get from cached DB?
                $view->with('search_duration_select', [1 => '1 Month', 2 => '3 Month']);
            //endregion
        });


        // set easier custom name for morph relation
        Relation::morphMap([
            'classroom' => 'App\Classroom',
            'booking' => 'App\Booking',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
