<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\Report;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\Report\GetNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\ReportFileNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Report\GetNewsReportUseCase;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\FileResponseFactory;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\HtmlResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetNewsReportController
{
    public function __construct(
        private GetNewsReportUseCase $useCase,
        private HtmlResponseFactory $htmlResponseFactory,
        private FileResponseFactory $fileResponseFactory
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $filename = $args['filename'];
            $getNewsReportResponse = ($this->useCase)(new GetNewsReportRequest($filename));
        } catch (RequestValidationException) {
            return $this->htmlResponseFactory->createDefault400BadRequestResponse($response);
        } catch (ReportFileNotFoundException) {
            return $this->htmlResponseFactory->createDefault404NotFoundResponse($response);
        }

        return $this->fileResponseFactory->createDownloadHtmlResponse(
            $response,
            $getNewsReportResponse->getReportFullFilename(),
            $filename
        );
    }
}
