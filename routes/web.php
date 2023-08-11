<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('oauth/{service}', [\App\Http\Controllers\OAuthController::class, 'redirect'])
        ->name('oauth.redirect');
    Route::get('oauth/{service}/callback', [\App\Http\Controllers\OAuthController::class, 'callback'])
        ->name('oauth.callback');
    Route::get('services/{service}/oauth', [\App\Http\Controllers\ServiceController::class, 'oauth'])
        ->name('services.oauth.redirect');
    Route::get('services/{service}/oauth/callback', [\App\Http\Controllers\ServiceController::class, 'oauthCallback'])
        ->name('services.oauth.callback');
});

Route::middleware(['webhook'])->group(function () {
    Route::get('channels/{channel}/webhook', [\App\Http\Controllers\ChannelController::class, 'challenge'])
        ->name('channels.challenge');

    Route::post('channels/{channel}/webhook', [\App\Http\Controllers\ChannelController::class, 'webhook'])
        ->name('channels.webhook');
});
