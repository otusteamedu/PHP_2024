<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\News;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\AddNewsRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\TitleNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\UrlNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\News\AddNewsUseCase;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\ValidationException;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\JsonResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;

class AddNewsController
{
    public function __construct(
        private AddNewsUseCase $useCase,
        private JsonResponseFactory $jsonResponseFactory
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $body = $request->getParsedBody();
            $url = $body['url'] ?? null;
            $addNewsResponse = ($this->useCase)(new AddNewsRequest($url));
        } catch (TitleNotFoundException | UrlNotFoundException $e) {
            return $this->jsonResponseFactory->createGeneralErrorResponse($response, $e->getMessage(), 400);
        } catch (RequestValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($response, $e->getErrors(), 400);
        } catch (ValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($response, $e->getErrors(), 422);
        } catch (RuntimeException) {
            return $this->jsonResponseFactory->createDefaultGeneralErrorResponse($response);
        }

        return $this->jsonResponseFactory->createResponse($response, ['id' => $addNewsResponse->getId()]);
    }
}
