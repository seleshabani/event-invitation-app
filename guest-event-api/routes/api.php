<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\TestController::class, 'index']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('events', \App\Http\Controllers\EventController::class);
    Route::post('guests/upload', [\App\Http\Controllers\GuestController::class, 'upload']);
});