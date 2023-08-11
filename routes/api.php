<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware(['instance', 'auth:sanctum'])
    ->prefix('v1')
    ->name('api.')
    ->group(function () {
        Route::get('channels/{channel}/user', [\App\Http\Controllers\ChannelUserController::class, 'show'])
            ->name('channel.user');
    });
