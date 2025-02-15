<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusQueueApp\Routes;

use SlavaMakhov\OtusQueueApp\Http\Controllers\MainController;
use SlavaMakhov\OtusQueueApp\Route;

class Web extends Route
{
    /** @var array */
    protected array $routes = [
        '/' => [MainController::class, 'index'],
        '/send-data' => [MainController::class, 'sendData'],
    ];
}
