<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Service Drivers
    |--------------------------------------------------------------------------
    |
    | The available service drivers like Facebook Page, Facebook Messenger, etc.
    | New drivers need service classes that implement the Service interface.

    */
    'drivers' => [
        'facebook_page' => \App\Services\FacebookPage::class,
        'facebook_messenger' => \App\Services\FacebookMessenger::class,
    ],

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

    'slack' => [
        'error_webhook_url' => env('SLACK_ERROR_URL'),
        'error_channel' => env('SLACK_ERROR_CHANNEL'),
    ],
];
