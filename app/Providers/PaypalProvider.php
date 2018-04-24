<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PaypalProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('paypal.api_context', function ($app) {
            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    config('paypal.client_id'),     // ClientID
                    config('paypal.secret')      // ClientSecret
                )
            );
            $apiContext->setConfig(config('paypal.config'));
            return $apiContext;
        });
    }

    public function provides()
    {
        return ['paypal.api_context'];

    }
}
