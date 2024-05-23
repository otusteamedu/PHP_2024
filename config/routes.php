<?php

declare(strict_types=1);

use App\Application\UseCase\CreateNewsUseCase;
use App\Application\UseCase\Form\CreateNewsForm;
use App\Application\UseCase\Form\GenerateReportForm;
use App\Application\UseCase\GenerateReportUseCase;
use App\Application\UseCase\GetAllNewsUseCase;
use App\Infrastructure\Middleware\CreateNewsRequestMiddleware;
use App\Infrastructure\Middleware\GenerateReportRequestMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;

return function (App $app, ContainerInterface $container) {
    $app->post('/news', function (Request $request, Response $response, $args) use ($container) {
        /** @var CreateNewsForm $createNewsForm */
        $createNewsForm = $container->get(CreateNewsForm::class);

        /** @var CreateNewsUseCase $createNewsUseCase */
        $createNewsUseCase = $container->get(CreateNewsUseCase::class);

        $createNewsResponse = $createNewsUseCase($createNewsForm);

        $response->getBody()->write(json_encode($createNewsResponse));
        return $response->withHeader('Content-Type', 'application/json');
    })->add(CreateNewsRequestMiddleware::class);

    $app->get('/news', function (Request $request, Response $response, $args) use ($container) {
        /** @var GetAllNewsUseCase $getAllNewsUseCase */
        $getAllNewsUseCase = $container->get(GetAllNewsUseCase::class);
        $getAllNewsResponse = $getAllNewsUseCase();

        $response->getBody()->write(json_encode($getAllNewsResponse));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/report', function (Request $request, Response $response, $args) use ($container) {
        /** @var GenerateReportForm $generateReportForm */
        $generateReportForm = $container->get(GenerateReportForm::class);

        /** @var GenerateReportUseCase $generateReportUseCase */
        $generateReportUseCase = $container->get(GenerateReportUseCase::class);

        $generateReportResponse = $generateReportUseCase($generateReportForm);

        $response->getBody()->write(json_encode($generateReportResponse));
        return $response->withHeader('Content-Type', 'application/json');
    })->add(GenerateReportRequestMiddleware::class);

    $app->addRoutingMiddleware();

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);

    $errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (Request $request, Throwable $exception, bool $displayErrorDetails) {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode(['error' => 'Not Found']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    });

    $errorMiddleware->setErrorHandler(InvalidArgumentException::class, function (Request $request, Throwable $exception, bool $displayErrorDetails) {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode(['error' => 'Validation Error', 'message' => $exception->getMessage()]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    });

    $errorMiddleware->setDefaultErrorHandler(function (Request $request, Throwable $exception, bool $displayErrorDetails, bool $logError, bool $logErrorDetails) {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode(['error' => 'An internal error has occurred.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    });
};
