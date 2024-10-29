<?php

namespace Irayu\Hw15;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

class App
{
    public function run()
    {
        $app = AppFactory::create();
        $app->addRoutingMiddleware();
        $futureConfigs = parse_ini_file('../config.ini');

        $app->post(
            pattern: '/api/news/add',
            callable: function (Request $request, Response $response, $args) use ($futureConfigs) {
                return (new Infrastructure\Http\AddNewsController(
                    new Infrastructure\Factory\FirstFactory(),
                    new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath']),
                    new Infrastructure\Gateway\NewsLoader(),
                ))($request, $response, $args);
            }
        );
        $app->get(
            pattern: '/api/news/list',
            callable: function (Request $request, Response $response, $args) use ($futureConfigs) {
                return (new Infrastructure\Http\ListNewsController(
                    new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath'])
                ))($request, $response, $args);
            }
        );
        $app->post(
            pattern: '/api/news/report/create',
            callable: function (Request $request, Response $response, $args) use ($futureConfigs) {
                return (new Infrastructure\Http\CreateReportNewsController(
                    new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath']),
                    new Infrastructure\Repository\FileReportRepository($futureConfigs['repoReportPath'])
                ))($request, $response, $args);
            }
        );
        $app->get(
            pattern: '/api/news/report/get/{id}/{hash}',
            callable: function (Request $request, Response $response, $args) use ($futureConfigs) {
                return (new Infrastructure\Http\GetReportNewsController(
                    new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath']),
                    new Infrastructure\Repository\FileReportRepository($futureConfigs['repoReportPath'])
                ))($request, $response, $args);
            }
        );

        $app->run();
    }
}
