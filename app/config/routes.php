<?php

declare(strict_types=1);

use Slim\App;
use App\Infrastructure\Http\Action\HealthCheckAction;

return function (App $app) {
    $app->get('/', HealthCheckAction::class);
};
