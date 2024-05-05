<?php

declare(strict_types=1);

use App\Application\UseCase\News\{AddNewsUseCase, GenerateReportUseCase, ListNewsUseCase};
use App\Application\UseCase\News\Converter\HTMLReportConverter;
use App\Application\UseCase\News\DTO\StoreNewsRequest;
use App\Application\Settings\SettingsInterface;
use App\Infrastructure\Export\FileSystemReportSaver;
use App\Infrastructure\Persistence\Repository\DatabaseNewsRepository;
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
            $response->getBody()->write(json_encode($payload));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        });
        $group->post('', function (Request $request, Response $response, array $args) {
            $body = $request->getParsedBody();
            $newsRequest = new StoreNewsRequest(
                $body['url'],
                $body['title']
            );

            $id = (new AddNewsUseCase($this->get(DatabaseNewsRepository::class)))($newsRequest);

            $payload = compact('id');
            $response->getBody()->write(json_encode($payload));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        });
        $group->get('/report-html/{ids:.*}', function (Request $request, Response $response, array $args) {
            $action = $this->make(GenerateReportUseCase::class, [
                'reportConverter' => $this->get(HTMLReportConverter::class),
                'reportExporter' => $this->get(FileSystemReportSaver::class),
            ]);

            $settings = $this->get(SettingsInterface::class);

            $ids = array_map('intval', explode('/', $args['ids']));
            $file = $action($settings, ...$ids);

            $payload = compact('file');
            $response->getBody()->write(json_encode($payload));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        });
    });
};
