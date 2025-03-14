<?php

use App\Infrastructure\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/v1/news/', [ApiController::class, 'store']);
Route::get('/api/v1/news/', [ApiController::class, 'index']);
Route::get('/api/v1/news/{id}', [ApiController::class, 'show']);
