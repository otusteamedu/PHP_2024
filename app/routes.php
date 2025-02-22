<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Bus\MainBus;
use App\Application\DTO\OrderDto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/order', function (Group $group) {
        $group->post('', function (Request $request, Response $response) {
            $body = $request->getParsedBody();
            $orderDTO = new OrderDto(
                cook: $body['cook'],
                cookingProcess: $body['cookingProcess'],
                productCustomizers: $body['productCustomizers'] ?? null
            );

            $this->get(MainBus::class)->execute($orderDTO);

            return $response;
        });
        $group->post('/cooked', function (Request $request, Response $response) {
            $body = $request->getParsedBody();
            $orderDTO = new OrderDto(id: $body['id']);

            $this->get(MainBus::class)->execute($orderDTO);

            return $response;
        });
    });
};
