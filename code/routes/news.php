<?php

use App\Infrastructure\Http\AddNewsController;
use App\Infrastructure\Http\NewsListController;
use App\Infrastructure\Http\ReportController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/api/news/report', ReportController::class);

Route::get('/api/news', NewsListController::class);

Route::post('/api/news', AddNewsController::class)->withoutMiddleware(VerifyCsrfToken::class);
