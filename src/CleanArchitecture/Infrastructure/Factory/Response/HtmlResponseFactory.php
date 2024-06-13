<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response;

use Psr\Http\Message\ResponseInterface as Response;

class HtmlResponseFactory
{
    public function createResponse(Response $response, string $html, int $statusCode = 200): Response
    {
        $response = $response
            ->withStatus($statusCode)
            ->withHeader('Content-type', 'text/html');

        $response->getBody()->write($html);
        return $response;
    }

    public function create400BadRequestResponse(Response $response, string $html): Response
    {
        return $this->createResponse($response, $html, 400);
    }

    public function createDefault400BadRequestResponse(Response $response): Response
    {
        return $this-> create400BadRequestResponse($response, '<html><body><div>Bad Request!</div></body></html>');
    }

    public function create404NotFoundResponse(Response $response, string $html): Response
    {
        return $this->createResponse($response, $html, 404);
    }

    public function createDefault404NotFoundResponse(Response $response): Response
    {
        return $this->create404NotFoundResponse($response, '<html><body><div>Not Found!</div></body></html>');
    }
}
