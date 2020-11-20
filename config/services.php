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
    // 'facebook' => [
    // 'client_id' => env('701551120793576'),         // Your GitHub Client ID
    // 'client_secret' => env('067ac523f84a160b0c33bd547167ed7a'), // Your GitHub Client Secret
    // 'redirect' => 'localhost/truenetmovie/public/login/facebook/callback',
   
    // ],

    'facebook' => [
    'client_id' => '1037148233375083',
    'client_secret' => '151acd5649cb0dc466132c37896fd02f',
    'redirect' => 'https://localhost/truenetmovie/public/login/facebook/callback',
  ],
  'google' => [
    'client_id' => '302248450561-n1a2ghfgn8dj9fb80d9rdl60frg00109.apps.googleusercontent.com',
    'client_secret' => 'pUBFWpQpCKljhKNjs5UBgtX1',
    'redirect' => 'https://localhost/truenetmovie/public/login/google/callback',
  ],

];
