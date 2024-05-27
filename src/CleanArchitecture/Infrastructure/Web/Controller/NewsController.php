<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\AddNewsRequest;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\GenerateNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\TitleNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\UrlNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\AddNewsUseCase;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\GenerateNewsReportUseCase;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\GetNewsUseCase;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\ValidationException;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\JsonResponseFactory;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Service\View\ViewService;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;

class NewsController
{
    public function __construct(
        private Container $container,
        private JsonResponseFactory $jsonResponseFactory
    ) {
    }

    public function addNews(Request $request, Response $response, array $args): Response
    {
        /**
         * @var AddNewsUseCase $useCase
         */
        $useCase = $this->container->get(AddNewsUseCase::class);
        try {
            $body = $request->getParsedBody();
            $url = $body['url'] ?? null;
            $news = ($useCase)(new AddNewsRequest($url));
        } catch (TitleNotFoundException | UrlNotFoundException $e) {
            return $this->jsonResponseFactory->createGeneralErrorResponse($response, $e->getMessage(), 400);
        } catch (ValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($response, $e->getErrors(), 400);
        } catch (RuntimeException) {
            return $this->jsonResponseFactory->createDefaultGeneralErrorResponse($response);
        }

        return $this->jsonResponseFactory->createResponse($response, ['id' => $news->getId()]);
    }

    public function getNews(Request $request, Response $response, array $args): Response
    {
        /**
         * @var GetNewsUseCase $useCase
         */
        $useCase = $this->container->get(GetNewsUseCase::class);
        try {
            $news = ($useCase)();
        } catch (RuntimeException) {
            return $this->jsonResponseFactory->createDefaultGeneralErrorResponse($response);
        }

        /**
         * @var ViewService $viewService
         */
        $viewService = $this->container->get(ViewService::class);
        $news = $viewService->prepareNews($news);
        return $this->jsonResponseFactory->createResponse($response, ['news' => $news]);
    }

    public function generateReport(Request $request, Response $response, array $args): Response
    {
        /**
         * @var GenerateNewsReportUseCase $useCase
         */
        $useCase = $this->container->get(GenerateNewsReportUseCase::class);
        $body = $request->getParsedBody();
        $ids = $body['ids'] ?? null;
        try {
            $link = ($useCase)(new GenerateNewsReportRequest($ids));
        } catch (ValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($response, $e->getErrors(), 400);
        } catch (RuntimeException) {
            return $this->jsonResponseFactory->createDefaultGeneralErrorResponse($response);
        }

        /**
         * @var ViewService $viewService
         */
        return $this->jsonResponseFactory->createResponse($response, ['link' => $link]);
    }
}
