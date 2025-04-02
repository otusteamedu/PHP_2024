<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideosRowDataGatewayController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('all', VideosController::class)->name('getAll');
Route::get('create', [VideosRowDataGatewayController::class, 'create'])->name('rowDataGateway');
Route::get('update', [VideosRowDataGatewayController::class, 'update'])->name('rowDataGateway');
