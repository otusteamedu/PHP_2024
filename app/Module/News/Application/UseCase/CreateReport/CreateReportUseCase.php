<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\CreateReport;

use Core\Domain\ValueObject\Uuid;
use Module\News\Application\Service\Interface\ReportGeneratorServiceInterface;
use Module\News\Domain\Repository\NewsQueryRepositoryInterface;

final readonly class CreateReportUseCase
{
    public function __construct(
        private NewsQueryRepositoryInterface $repository,
        private ReportGeneratorServiceInterface $reportGeneratorService,
    ) {
    }

    public function __invoke(CreateReportRequest $request): CreateReportResponse
    {
        $ids = array_map(static fn (string $uuid): Uuid  => new Uuid($uuid), $request->ids);
        $newsCollection = $this->repository->getAllByIds(...$ids);
        $reportUrl = $this->reportGeneratorService->generate($newsCollection);

        return new CreateReportResponse($reportUrl->getValue());
    }
}
