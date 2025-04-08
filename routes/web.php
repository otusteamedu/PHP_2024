<?php

use App\Infrastructure\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/v1/leads', [ApiController::class, 'addLead']);
Route::get('/api/v1/leads/{leadId}/status', [ApiController::class, 'getLeadStatus']);
Route::get('/api/v1/leads/{leadId}/result', [ApiController::class, 'getLeadResult']);
