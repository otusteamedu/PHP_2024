<?php

declare(strict_types=1);

use App\Application\Actions\Category\AddSubscriberCategoryAction;
use App\Application\Actions\Category\CreateCategoryAction;
use App\Application\Actions\Category\RemoveSubscriberCategoryAction;
use App\Application\Actions\News\ChangeNewsStateAction;
use App\Application\Actions\News\CreateNewsAction;
use App\Application\Actions\News\DownloadNewsAction;
use App\Application\Actions\News\ListNewsAction;
use App\Application\Actions\News\ListUserNewsAction;
use App\Application\Actions\News\ViewNewsAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\LoginAction;
use App\Application\Actions\User\ViewUserAction;
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
        $group->get('/{username}', ViewUserAction::class);
        $group->post('', CreateUserAction::class);
    });

    $app->get('/my-news', ListUserNewsAction::class);

    $app->group('/news', function (Group $group) {
        $group->get('', ListNewsAction::class);
        $group->post('', CreateNewsAction::class);
        $group->get('/{id}', ViewNewsAction::class);
        $group->patch('/{id}', ChangeNewsStateAction::class);
        $group->get('/export/{id}.{extension}', DownloadNewsAction::class);
    });

    $app->group('/categories', function (Group $group) {
        $group->post('', CreateCategoryAction::class);
        $group->post('/subscribe/{category_id}', AddSubscriberCategoryAction::class);
        $group->delete('/subscribe/{category_id}', RemoveSubscriberCategoryAction::class);
    });

    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAction::class);
    });
};
