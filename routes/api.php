<?php

global $app;

use App\Http\Response;
use App\Http\Router;

Router::post('/create', static function (array $queryParams, array $bodyParams) use ($app): void {
    $event = $app->event->add($bodyParams);

    $response = new Response([
        'data' => $event
    ]);

    $response->send();
});

Router::get('/index', static function (array $queryParams, array $bodyParams) use ($app): void {
    $response = new Response([
        'data' => iterator_to_array($app->event->find($queryParams))
    ]);

    $response->send();
});

Router::post('/flush', static function () use ($app): void {
    $response = new Response([
        'data' => $app->event->flush()
    ]);

    $response->send();
});
