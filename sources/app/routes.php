<?php

declare(strict_types=1);

use App\Infrastructure\Http\GetStatusTaskController;
use App\Infrastructure\Http\SubmitTaskController;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->group('/task', function (Group $group) {
        $group->post('/create', SubmitTaskController::class);
        $group->get('/status', GetStatusTaskController::class);
    });
};
