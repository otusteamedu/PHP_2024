<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\GenerateReport;

use App\MediaMonitoring\Application\UseCase\CreateReport\CreateReportRequest;
use App\MediaMonitoring\Application\UseCase\CreateReport\CreateReportUseCase;
use App\MediaMonitoring\Domain\Repository\PostRepositoryInterface;
use App\MediaMonitoring\Domain\Service\ReportGeneratorInterface;
use App\Shared\Domain\Exception\CouldNotSaveEntityException;

final readonly class GenerateReportUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private ReportGeneratorInterface $reportGenerator,
        private CreateReportUseCase $createReportUseCase,
    ) {}

    /**
     * @throws CouldNotSaveEntityException
     */
    public function execute(GenerateReportRequest $request): GenerateReportResponse
    {
        $postIds = $request->postIds;

        $posts = empty($postIds)
            ? $this->postRepository->findAll()
            : $this->postRepository->findByIds($postIds);

        $content = $this->reportGenerator->generate(...$posts);

        $reportId = $this->createReportUseCase->execute(
            new CreateReportRequest(
                $this->reportGenerator->getType(),
                $content
            )
        )->reportId;

        return new GenerateReportResponse($reportId);
    }
}
