<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\GetNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\ReportFileNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\GetNewsReportUseCase;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\FileResponseFactory;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response\HtmlResponseFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ReportController
{
    public function __construct(
        private ContainerInterface $container,
        private HtmlResponseFactory $htmlResponseFactory,
        private FileResponseFactory $fileResponseFactory
    ) {
    }

    public function getNewsReport(Request $request, Response $response, array $args):  Response
    {
        /**
         * @var GetNewsReportUseCase $useCase
         */
        $useCase = $this->container->get(GetNewsReportUseCase::class);
        try {
            $filename = $args['filename'];
            $reportFullFilename = ($useCase)(new GetNewsReportRequest($filename));
        } catch (ReportFileNotFoundException) {
            return $this->htmlResponseFactory->createDefault404NotFoundResponse($response);
        }

        return $this->fileResponseFactory->createDownloadHtmlResponse($response, $reportFullFilename, $filename);
    }
}
