<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\RateController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/rates', RateController::class);

Route::get('/order/{id}', [OrderController::class, 'getOrderById']);

Route::get('/cancelOrder/{id}', [OrderController::class, 'cancelOrderById']);

# Testing
Route::get('/test', [OrderController::class, 'testing']);



Route::post('/createOrder', [OrderController::class, 'createOrder']);
