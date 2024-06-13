<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\News;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\News\GetNewsUseCase;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\JsonResponseFactory;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Service\View\ViewService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;

class GetNewsController
{
    public function __construct(
        private GetNewsUseCase $useCase,
        private JsonResponseFactory $jsonResponseFactory,
        private ViewService $viewService
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {

        try {
            $newsDtoList = ($this->useCase)();
        } catch (RuntimeException) {
            return $this->jsonResponseFactory->createDefaultGeneralErrorResponse($response);
        }

        $news = $this->viewService->prepareNews($newsDtoList);
        return $this->jsonResponseFactory->createResponse($response, ['news' => $news]);
    }
}
