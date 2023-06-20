<?php

use Illuminate\Http\Request;
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

        Route::resource('instances.services', \App\Http\Controllers\ServiceController::class)
             ->only(['index', 'store', 'destroy']);

        Route::get('webhook/mock', [\App\Http\Controllers\WebhookController::class, 'mock'])
             ->name('webhook.mock');

    });
