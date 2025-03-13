<?php

use Illuminate\Support\Facades\Route;

Route::prefix('news')->group(function () {
    Route::post('/', \App\Infrastructure\Http\Controllers\SubmitNewsController::class);
    Route::get('/', \App\Infrastructure\Http\Controllers\ListNewsController::class);
    Route::post('/report', \App\Infrastructure\Http\Controllers\ReportNewsController::class);
});
