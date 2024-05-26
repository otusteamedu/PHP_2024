<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Application\Request\GenerateNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\NewsReportServiceInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Service\ValidationServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Exception\RequestValidationException;

class GenerateNewsReportUseCase extends BaseUseCase
{
    public function __construct(
        ValidationServiceInterface $validationService,
        private NewsRepositoryInterface $newsRepository,
        private NewsReportServiceInterface $newsReportService,
        private GenerateLinkServiceInterface $generateLinkService
    ) {
        parent::__construct($validationService);
    }

    /**
     * @throws RequestValidationException
     */
    public function __invoke(GenerateNewsReportRequest $request): string
    {
        $this->validateRequestModel($request);
        $news = $this->newsRepository->findByIds($request->getIds());
        $filename =  $this->newsReportService->generateReport($news);
        return $this->generateLinkService->generateNewsReportFileLink($filename);
    }
}