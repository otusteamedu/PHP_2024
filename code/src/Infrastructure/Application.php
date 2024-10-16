<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Viking311\Api\Infrastructure\Factory\Command\AddEventCommandFactory;
use Viking311\Api\Infrastructure\Factory\Command\GetStatusCommandFactory;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0',
    description: 'Приложение принимает заявки на проведение мероприятий.',
    title: 'API заявок на проведение мероприятий',
)]
class Application
{
    #[OA\Post(
        path: '/api/v1/events',
        description: 'Создание новой заявки',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref:'#/components/schemas/AddEventRequest'
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Возвращает Id созданной заявки',
                content: new OA\JsonContent(
                    ref:'#/components/schemas/AddEventResponse'
                ),
            ),
            new OA\Response(
                response: 400,
                description: 'Не валидные данные
                ',
            )
        ]
    )]
    #[OA\Get(
        path: '/api/v1/events/{eventId}',
        description: 'Получение статуса заявки по её Id',
        parameters: [
            new OA\Parameter(
                name: 'eventId',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'string'
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Возвращает статус заявки, если она существует',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/GetStatusResponse'
                )
            )
        ]
    )]
    public function run(): void
    {
        $app = AppFactory::create();

        $app->addRoutingMiddleware();

        $errorMiddleware = $app->addErrorMiddleware(true, true, true);

        $app->post('/api/v1/events', function (Request $request, Response $response){
            $cmd = AddEventCommandFactory::createInstance();
            return $cmd->execute($request, $response);
        });


        $app->get('/api/v1/events/{eventId}', function (Request $request, Response $response, array $args){
            $cmd = GetStatusCommandFactory::createInstance();
            return $cmd->execute($request, $response, $args['eventId']);
        });

        $app->run();
    }
}
