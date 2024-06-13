<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\Report;

use AlexanderGladkov\CleanArchitecture\Application\Service\Report\GetReportFullFilenameParams;
use AlexanderGladkov\CleanArchitecture\Application\Service\Validation\RequestValidationServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\BaseUseCase;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\Report\GetNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\NewsReportServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\ReportFileNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Response\Report\GetNewsReportResponse;

class GetNewsReportUseCase extends BaseUseCase
{
    public function __construct(
        private RequestValidationServiceInterface $requestValidationService,
        private NewsReportServiceInterface $newsReportService
    ) {
        parent::__construct();
    }

    /**
     * @throws RequestValidationException
     * @throws ReportFileNotFoundException
     */
    public function __invoke(GetNewsReportRequest $request): GetNewsReportResponse
    {
        $this->checkRequestValidationErrors($this->requestValidationService->validateGetNewsReportRequest($request));
        $getReportFullFilenameParams = new GetReportFullFilenameParams($request->getFilename());
        $getReportFullFilenameResult = $this->newsReportService->getReportFullFilename($getReportFullFilenameParams);
        return new GetNewsReportResponse($getReportFullFilenameResult->getFullFilename());
    }
}
