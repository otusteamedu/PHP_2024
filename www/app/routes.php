<?php

declare(strict_types=1);

use App\Domain\User\User;
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

    $app->get('/test', function (Request $request, Response $response) {
        $user = new User('testUsername');
        $response->getBody()->write($user->username);
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', \App\Application\Actions\User\ListUsersAction::class);
        $group->get('/{id}', \App\Application\Actions\User\ViewUserAction::class);
        $group->post('', \App\Application\Actions\User\CreateUserAction::class);
    });

    $app->group('/news', function (Group $group) {
        $group->get('', \App\Application\Actions\News\ListNewsAction::class);
        $group->post('', \App\Application\Actions\News\CreateNewsAction::class);
        $group->get('/{id}', \App\Application\Actions\News\ViewNewsAction::class);
        $group->get('/{id}/state/{state}', \App\Application\Actions\News\ChangeNewsStateAction::class);
        $group->get('/export/{id}.{extension}', \App\Application\Actions\News\DownloadNewsAction::class);
    });

    $app->group('/categories', function (Group $group) {
        $group->post('', \App\Application\Actions\Category\CreateCategoryAction::class);
        $group->post('/sub/{category_id}', \App\Application\Actions\Category\SubscribeCategoryAction::class);
    });

    $app->group('/auth', function (Group $group) {
        $group->post('/login', \App\Application\Actions\User\LoginAction::class);
    });
};
