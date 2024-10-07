<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Controller;

use Exception;
use InvalidArgumentException;
use Viking311\Queue\Application\UseCase\AddEvent\AddEventRequest;
use Viking311\Queue\Application\UseCase\AddEvent\AddEventUseCase;
use Viking311\Queue\Infrastructure\Http\Request;
use Viking311\Queue\Infrastructure\Http\Response;

readonly class AddEventController
{
    /**
     * @param AddEventUseCase $useCase
     */
    public function __construct(
        private AddEventUseCase $useCase
    ){
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function __invoke(Request $request, Response $response): void
    {
        $data = $request->getPost();
        $useCaseRequest = new AddEventRequest(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['eventDate'] ?? '',
            $data['address'] ?? '',
                (isset($data['guest']) ? (int) $data['guest'] : 0)
        );
        try {
            ($this->useCase)($useCaseRequest);
            $response->setContent('Ваш запрос обрабатывается');
        } catch (InvalidArgumentException $ex) {
            $response->setResultCode(400);
            $response->setContent($ex->getMessage());
        } catch (Exception) {
            $response->setResultCode(500);
            $response->setContent('Internal server error');
        }
    }

}
