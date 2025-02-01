<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp\Routes;

use SlavaMakhov\OtusWebserversApp\Http\Controllers\MainController;
use SlavaMakhov\OtusWebserversApp\Route;

class Web extends Route
{
    /** @var array */
    protected array $routes = [
        '/' => [MainController::class, 'index'],
        '/string-validate' => [MainController::class, 'stringValidate'],
    ];
}
