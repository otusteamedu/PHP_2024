<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\News;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\GenerateNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\News\GenerateNewsReportUseCase;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\JsonResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;

class GenerateNewsReportController
{
    public function __construct(
        private GenerateNewsReportUseCase $useCase,
        private JsonResponseFactory $jsonResponseFactory
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $body = $request->getParsedBody();
        $ids = $body['ids'] ?? null;
        try {
            $generateNewsReportResponse = ($this->useCase)(new GenerateNewsReportRequest($ids));
        } catch (RequestValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($response, $e->getErrors(), 400);
        }  catch (RuntimeException) {
            return $this->jsonResponseFactory->createDefaultGeneralErrorResponse($response);
        }

        return $this->jsonResponseFactory->createResponse($response, [
            'link' => $generateNewsReportResponse->getLinkToReportFile()
        ]);
    }
}
