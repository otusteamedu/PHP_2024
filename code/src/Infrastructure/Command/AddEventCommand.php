<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Command;

use Exception;
use InvalidArgumentException;
use Viking311\Api\Application\UseCase\AddEvent\AddEventRequest;
use Viking311\Api\Application\UseCase\AddEvent\AddEventUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

readonly class AddEventCommand
{
    /**
     * @param AddEventUseCase $useCase
     */
    public function __construct(
        private AddEventUseCase $useCase
    ) {
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function execute(Request $request, Response $response): Response
    {
        $json = $request->getBody()->read($request->getBody()->getSize());

        if (!json_validate($json)) {
            return $response
                ->withStatus(400, 'Bad request');
        }

        $data = json_decode($json, true);

        if (!is_array($data)) {
            return $response
                ->withStatus(400, 'Bad request');
        }

        $useCaseRequest = new AddEventRequest(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['eventDate'] ?? '',
            $data['address'] ?? '',
            (isset($data['guest']) ? (int) $data['guest'] : 0)
        );
        try {
            $useCaseResponse = ($this->useCase)($useCaseRequest);
            $response->getBody()->write(json_encode($useCaseResponse));
        } catch (InvalidArgumentException $ex) {
            $errResponse  = $response
                ->withStatus(400, 'Bad request');
            $errResponse->getBody()
                ->write($ex->getMessage());
            return $errResponse;
        } catch (Exception) {
            return $response->withStatus(500, 'Internal ');
        }

        return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
