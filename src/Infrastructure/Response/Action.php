<?php

declare(strict_types=1);

namespace App\Infrastructure\Response;

use Psr\Http\Message\ResponseInterface as Response;

class Action
{
    public function __construct(private Response $response)
    {
    }

    public function respondWithData($data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }
}
