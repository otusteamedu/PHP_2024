<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\News;

use AlexanderGladkov\CleanArchitecture\Application\Factory\NewsDtoFactory;
use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkParams;
use AlexanderGladkov\CleanArchitecture\Application\Service\Validation\RequestValidationServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\BaseUseCase;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\GenerateNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\NewsReportServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Response\News\GenerateNewsReportResponse;
use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;

class GenerateNewsReportUseCase extends BaseUseCase
{
    public function __construct(
        private RequestValidationServiceInterface $requestValidationService,
        private NewsRepositoryInterface $newsRepository,
        private NewsReportServiceInterface $newsReportService,
        private GenerateLinkServiceInterface $generateLinkService
    ) {
        parent::__construct();
    }

    /**
     * @throws RequestValidationException
     */
    public function __invoke(GenerateNewsReportRequest $request): GenerateNewsReportResponse
    {
        $this->checkRequestValidationErrors(
            $this->requestValidationService->validateGenerateNewsReportRequest($request)
        );

        $news = $this->newsRepository->findByIds($request->getIds());
        $newsDtoList = (new NewsDtoFactory())->createFromNewsList($news);
        $generateReportResult =  $this->newsReportService->generateReport($newsDtoList);
        $generateLinkParams = new GenerateLinkParams($generateReportResult->getFilename());
        $generateLinkResult = $this->generateLinkService->generateLinkToNewsReportToFile($generateLinkParams);
        return new GenerateNewsReportResponse($generateLinkResult->getLinkToFile());
    }
}
