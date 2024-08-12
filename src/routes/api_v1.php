<?php

use App\Http\Controllers\Api\V1\AuthorNewsController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\AuthorsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('news', NewsController::class)->except(['update']);
    Route::put('news/{news}', [NewsController::class, 'replace']);
    Route::patch('news/{news}', [NewsController::class, 'update']);
    Route::apiResource('authors', AuthorsController::class);
    Route::apiResource('authors.news', AuthorNewsController::class)->except(['update']);
    Route::put('authors/{author}/news/{news}', [AuthorNewsController::class, 'replace']);
    Route::patch('authors/{author}/news/{news}', [AuthorNewsController::class, 'update']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

