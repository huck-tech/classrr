<?php

namespace App\Providers;

use App\Twilio;
use Illuminate\Support\ServiceProvider;

class TwilioServiceProvider extends ServiceProvider
{
    protected $defer = false;
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app ?: app();

        $this->mergeConfigFrom(__DIR__.'/../../config/twilio.php', 'twilio');
        $this->publishes([
            __DIR__.'/../../config/twilio.php' => config_path('twilio.php'),
        ]);

        $this->app['twilio'] = $this->app->singleton('twilio', function($app) {
            return new Twilio($app['config']);
        });

    }

    public function provides()
    {
        return ['twilio'];

    }
}
