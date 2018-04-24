<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google_maps_key' => env('GOOGLE_MAPS_KEY'),

    'google' => [
        'client_id' => '153668187557-aap072v7a21cdsv4f5e2hdq5u0mjn09u.apps.googleusercontent.com',
        'client_secret' => 'wXS0uIekXKHElH_2UTbxBpIJ',
        'redirect' => env('APP_URL') . '/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '202442830222361',
        'client_secret' => '4dd557146e842856eed0b9c4e07410a1',
        'redirect' => env('APP_URL') . '/auth/facebook/callback',
    ],

    'linkedin' => [
        'client_id' => '81mtj0lfv9oxka',
        'client_secret' => 'w5rFhTKQLA1fOK0V',
        'redirect' => env('APP_URL') . '/auth/linkedin/callback',
    ],

];
