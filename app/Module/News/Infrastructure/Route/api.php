<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Module\News\Infrastructure\Controller\NewsController;

Route::post('api/v1/news', [NewsController::class, 'create']);
Route::get('api/v1/news/{id}', [NewsController::class, 'getStatus']);
