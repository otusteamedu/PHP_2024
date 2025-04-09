<?php

use App\Http\Controllers\Court\CreateController;
use App\Http\Controllers\Court\DestroyController;
use App\Http\Controllers\Court\EditController;
use App\Http\Controllers\Court\IndexController;
use App\Http\Controllers\Court\ParseController;
use App\Http\Controllers\Court\ShowController;
use App\Http\Controllers\Court\StoreController;
use App\Http\Controllers\Court\UpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Hello!";
});

Route::get('courts', IndexController::class)->name("court.index");
Route::get('courts/create', CreateController::class)->name("court.create");
Route::post('courts', StoreController::class)->name("court.store");
Route::get('courts/{court}', ShowController::class)->whereUuid('court')->name("court.show");
Route::get('courts/{court}/edit', EditController::class)->whereUuid('court')->name("court.edit");
Route::patch('courts/{court}', UpdateController::class)->whereUuid('court')->name("court.update");
Route::delete('courts/{court}', DestroyController::class)->whereUuid('court')->name("court.destroy");

Route::get('courts/parse', ParseController::class)->name("court.parse");
