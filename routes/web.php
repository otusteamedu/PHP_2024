<?php

use App\Infrastructure\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/v1/news/add', [ApiController::class, 'addNews']);
Route::get('/api/v1/news/', [ApiController::class, 'index']);
Route::get('/api/v1/news/summary', [ApiController::class, 'summary']);
