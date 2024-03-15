<?php

use Bunker\LaravelSpeedDate\Http\Controllers\DatingEventController;
use Illuminate\Support\Facades\Route;

Route::name('speed_date.')->middleware(['web', 'auth', 'redirectusertoevent'])->group(function () {
    Route::resources(['events' => DatingEventController::class]);
    Route::prefix('events')->name('events.')->group(function () {
        Route::controller(DatingEventController::class)->group(function () {
            Route::post('user-uploads', 'uploadUsers')->name('uploadUsers');
            Route::post('{eventId}/{userId}/remove-participant', 'removeParticipant')->name('removeParticipant');
        });
    });
    Route::prefix('ratings')->name('ratings.')->group(function () {
        Route::controller(\Bunker\LaravelSpeedDate\Http\Controllers\RatingEventController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('store', 'store')->name('store');
        });
    });
});


