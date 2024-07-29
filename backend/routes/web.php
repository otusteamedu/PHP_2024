<?php

use App\Http\Controllers\RateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('/rates', RateController::class);

    //Route::post('/create_order', [OrderCreateController::class, 'createOrder']);
});

Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return 'Admin dashboard';
        });

        Route::get('/users', function () {
            return 'User list';
        });
});
