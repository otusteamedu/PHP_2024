<?php

declare(strict_types=1);

use App\Application\UseCase\News\{AddNewsUseCase, GenerateReportUseCase, ListNewsUseCase};
use App\Application\UseCase\News\DTO\StoreNewsRequest;
use App\Infrastructure\Converter\HTMLReportConverter;
use App\Infrastructure\Settings\SettingsInterface;
use App\Infrastructure\Export\FileSystemReportSaver;
use App\Infrastructure\Persistence\Repository\DatabaseNewsRepository;
use App\Infrastructure\Response\Action;
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

    $app->group('/news', function (Group $group) {
        $group->get('', function (Request $request, Response $response, array $args) {
            $news = ($this->get(ListNewsUseCase::class))();
            $payload = compact('news');
            $actionResponse = new Action($response, 201);

            return $actionResponse->respondWithData($payload);
        });
        $group->post('', function (Request $request, Response $response, array $args) {
            $body = $request->getParsedBody();
            $newsRequest = new StoreNewsRequest(
                $body['url'],
                $body['title']
            );

            $id = (new AddNewsUseCase($this->get(DatabaseNewsRepository::class)))($newsRequest);

            $payload = compact('id');
            $actionResponse = new Action($response, 201);

            return $actionResponse->respondWithData($payload);
        });
        $group->get('/report-html/{ids:.*}', function (Request $request, Response $response, array $args) {
            $converter = $this->get(HTMLReportConverter::class);
            $settings = $this->get(SettingsInterface::class);

            $action = $this->make(GenerateReportUseCase::class, [
                'reportConverter' => $converter,
                'reportExporter' => $this->get(FileSystemReportSaver::class),
            ]);

            $ids = array_map('intval', explode('/', $args['ids']));
            $file = $action(...$ids);

            $payload = compact('file');
            $actionResponse = new Action($response);

            return $actionResponse->respondWithData($payload);
        });
    });
};
