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

        /**
         * The routing middleware should be added earlier than the ErrorMiddleware
         * Otherwise exceptions thrown from it will not be handled by the middleware
         */
        $app->addRoutingMiddleware();

        /**
         * Add Error Middleware
         *
         * @param bool                  $displayErrorDetails -> Should be set to false in production
         * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
         * @param bool                  $logErrorDetails -> Display error details in error log
         * @param \Psr\Log\LoggerInterface|null  $logger -> Optional PSR-3 Logger
         *
         * Note: This middleware should be added last. It will not handle any exceptions/errors
         * for middleware added after it.
         */
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);

        $futureConfigs = parse_ini_file('../config.ini');

        $app->post('/api/news/add', function (Request $request, Response $response, $args) use ($futureConfigs) {
            return (new Infrastructure\Http\AddNewsController(
                new Infrastructure\Factory\FirstFactory(),
                new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath']),
                new Infrastructure\Gateway\NewsLoader(),
            ))($request, $response, $args);
        });
        $app->get('/api/news/list', function (Request $request, Response $response, $args) use ($futureConfigs) {
            return (new Infrastructure\Http\ListNewsController(
                new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath'])
            ))($request, $response, $args);
        });
        $app->post(
            pattern: '/api/news/report/create',
            callable: function (Request $request, Response $response, $args) use ($futureConfigs) {
                return (new Infrastructure\Http\CreateReportNewsController(
                    new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath']),
                    new Infrastructure\Repository\FileReportRepository($futureConfigs['reportPath'])
                ))($request, $response, $args);
            }
        );
        $app->get(
            pattern: '/api/news/report/get/{id}/{hash}',
            callable: function (Request $request, Response $response, $args) use ($futureConfigs) {
                return (new Infrastructure\Http\GetReportNewsController(
                    new Infrastructure\Repository\FileNewsRepository($futureConfigs['repoNewsPath']),
                    new Infrastructure\Repository\FileReportRepository($futureConfigs['reportPath'])
                ))($request, $response, $args);
            }
        );

        $app->run();
    }
}
