<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Viking311\Api\Infrastructure\Factory\Command\AddEventCommandFactory;
use Viking311\Api\Infrastructure\Factory\Command\GetStatusCommandFactory;

/**
 * @OA\Info(
 *     title="API заявок на проведение мероприятий",
 *     description="Приложение принимает заявки на проведение мероприятий.",
 *     version="1.0"
 * )
 */
class Application
{
    /**
     * @OA\Post(
     *     path="/api/v1/events",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *              ref="#/components/schemas/AddEventRequest",
     *              example={"name": "Adam", "email": "example@example.com", "eventDate": "2024-12-25 12:00", "address": "address", "guest": 1}
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает Id созданной заявки",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/AddEventResponse",
     *             example={"eventId": "670f69ee1f624"}
     *         )
     *    )
     * )
     *
     * @OA\Get (
     *     path="/api/v1/events/{eventId}",
     *     description="Получение статуса заявки по её Id",
     *     @OA\Parameter (
     *         name="eventId",
     *         in="path",
     *         required=true,
     *         @OA\Schema (
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает статус заявки, если она существует",
     *         @OA\JsonContent(
     *              ref="#/components/schemas/GetStatusResponse"
     *         )
     *     )
     * )
     */
    public function run()
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
