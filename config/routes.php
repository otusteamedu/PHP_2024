<?php

declare(strict_types=1);

use App\Infrastructure\Controller\CreateNewsController;
use App\Infrastructure\Controller\GenerateReportController;
use App\Infrastructure\Controller\GetAllNewsController;
use App\Infrastructure\Middleware\CreateNewsRequestMiddleware;
use App\Infrastructure\Middleware\GenerateReportRequestMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;

return function (App $app) {
    $app->post('/news', CreateNewsController::class)
        ->add(CreateNewsRequestMiddleware::class);

    $app->get('/news', GetAllNewsController::class);

    $app->post('/report', GenerateReportController::class)
        ->add(GenerateReportRequestMiddleware::class);

    $app->addRoutingMiddleware();

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);

    $errorMiddleware->setErrorHandler(HttpNotFoundException::class,
        function (Request $request, Throwable $exception, bool $displayErrorDetails) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Not Found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        });

    $errorMiddleware->setErrorHandler(InvalidArgumentException::class,
        function (Request $request, Throwable $exception, bool $displayErrorDetails) {
            $response = new Response();
            $response->getBody()->write(json_encode([
                'error' => 'Validation Error',
                'message' => $exception->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        });

    $errorMiddleware->setDefaultErrorHandler(function (
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logError,
        bool $logErrorDetails
    ) {
        $response = new Response();
        $response->getBody()->write(json_encode(['error' => 'An internal error has occurred.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    });
};
