<?php

use Illuminate\Support\Facades\Route;

Route::prefix('news')->group(function () {
    Route::post('/', \App\Http\Controllers\SubmitNewsController::class);
    Route::get('/', \App\Http\Controllers\ListNewsController::class);
    Route::post('/report', \App\Http\Controllers\ReportNewsController::class);
});
