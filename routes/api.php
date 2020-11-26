<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/reset', [StoreController::class, 'reset']);

Route::group(['prefix' => 'balance'], function () {
    Route::get('/', [BalanceController::class, 'get']);
    Route::post('/', [BalanceController::class, 'create']);
});

Route::group(['prefix' => 'event'], function () {
    Route::post('/', [EventController::class, 'create']);
});
