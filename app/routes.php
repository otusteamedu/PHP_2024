<?php

declare(strict_types=1);

use App\Application\UseCase\ApiRequest\DTO\{RegisterRequest, StatusRequest};
use App\Application\UseCase\ApiRequest\{GetApiRequestStatusUseCase, RegisterApiRequestUseCase};
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Infrastructure\Response\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/api/v1', function (Group $group) {
        $group->group('/api_requests', function (Group $group) {
            $group->post('', function (Request $request, Response $response, array $args) {
                $body = $request->getParsedBody();
                $apiRequest = new RegisterRequest($body['body']);

                try {
                    $id = ($this->get(RegisterApiRequestUseCase::class))($apiRequest);
                } catch (DomainRecordNotFoundException $e) {
                    throw new HttpNotFoundException($request, $e->getMessage());
                }

                $payload = compact('id');
                $actionResponse = new Action($response);

                return $actionResponse->respondWithData($payload, 201);
            });

            $group->get('/{id}:status', function (Request $request, Response $response, array $args) {
                $statusRequest = new StatusRequest((int) $args['id']);

                try {
                    $rstatusResponse = ($this->get(GetApiRequestStatusUseCase::class))($statusRequest);
                } catch (DomainRecordNotFoundException $e) {
                    throw new HttpNotFoundException($request, $e->getMessage());
                }

                $payload = ['status' => $rstatusResponse->status];
                $actionResponse = new Action($response);

                return $actionResponse->respondWithData($payload);
            });
        });
    });
};
