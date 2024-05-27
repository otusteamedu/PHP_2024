<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\GenerateNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\NewsReportServiceInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\ValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Service\ValidationServiceInterface;

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
     * @throws ValidationException
     */
    public function __invoke(GenerateNewsReportRequest $request): string
    {
        $this->validateModel($request);
        $news = $this->newsRepository->findByIds($request->getIds());
        $filename =  $this->newsReportService->generateReport($news);
        return $this->generateLinkService->generateNewsReportFileLink($filename);
    }
}
