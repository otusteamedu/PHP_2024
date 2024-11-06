<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreateReport;

use App\MediaMonitoring\Application\Storage\ReportStorageInterface;
use App\MediaMonitoring\Domain\Entity\Report;
use App\MediaMonitoring\Domain\Repository\ReportRepositoryInterface;
use App\Shared\Domain\Exception\CouldNotSaveEntityException;

final readonly class CreateReportUseCase
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportStorageInterface $reportStorage,
    ) {}

    /**
     * @throws CouldNotSaveEntityException
     */
    public function execute(CreateReportRequest $request): CreateReportResponse
    {
        $type = $request->type;

        $content = $request->content;

        $path = $this->reportStorage->put($type, $content);

        $report = Report::make($type, $path);

        $report = $this->reportRepository->save($report);

        return new CreateReportResponse($report->id);
    }
}
