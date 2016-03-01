<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '93133365968-na3lasr5ikdcf8okgv7aksk08t43e8n7.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'ETCjT763V3QJQqEbhaPa3ZAh'),
        'redirect' => 'http://fluentkit.app/login/google/callback',
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', '562108620613771'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '2f3c6a33003f58a60bbfffd5d52b4d14'),
        'redirect' => 'http://fluentkit.app/login/facebook/callback',
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID', 'Yu9ws1nahcCu1T6ONFOTt8bvi'),
        'client_secret' => env('TWITTER_CLIENT_SECRET', 'faacQZQWwSIrfrQimFfs7rNrZNBexY9RX5PP8NjeoPGM6rNWIY'),
        'redirect' => 'http://fluentkit.app/login/twitter/callback',
    ],

];
