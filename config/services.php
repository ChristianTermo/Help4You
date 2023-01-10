<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '717888559922075', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'client_secret' => '5b95120049320cd6ff5fb47b46ef1fee', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'redirect' => ''
    ],

    'vonage' => [
        'sms_from' => 'Help4You'
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
               'secret' => env('MAILGUN_SECRET'),
               'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'google' => [
        'client_id' => '574724469770-k1l8118j03qldh9g6dp6v52fdppah02b.apps.googleusercontent.com',
        'client_secret' => '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', 
        'redirect' => ''
    ],

];
