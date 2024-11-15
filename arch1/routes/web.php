<?php

use Illuminate\Support\Facades\Route;

Route::get('/api/age', [App\Http\Controllers\ApiController::class, 'getAge']);
