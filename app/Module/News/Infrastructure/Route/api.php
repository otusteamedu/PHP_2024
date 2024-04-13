<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Module\News\Infrastructure\Controller\NewsController;

Route::post('news', [NewsController::class, 'create']);
Route::get('news', [NewsController::class, 'getList']);
Route::post('report', [NewsController::class, 'createReport']);
