<?php

declare(strict_types=1);

$app = require_once __DIR__ . '/../config/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;


$app->post('/request', static function (Request $request) use ($app) {
    return $app['create.request.controller']($request);
});

$app->get('/request/{id}', static function ($id) use ($app) {
    return $app['request.status.controller']($id);
});

$app->run();
