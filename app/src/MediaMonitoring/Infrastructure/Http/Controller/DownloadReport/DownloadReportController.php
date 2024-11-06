<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\DownloadReport;

use App\MediaMonitoring\Application\Storage\ReportStorageInterface;
use App\MediaMonitoring\Domain\Repository\ReportRepositoryInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/reports/download/{reportId}', 'reports.download', methods: ['GET'])]
final readonly class DownloadReportController
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportStorageInterface $reportStorage,
    ) {}

    public function __invoke(int $reportId): BinaryFileResponse
    {
        $report = $this->reportRepository->findById($reportId);

        if (null === $report) {
            $message = sprintf(
                'The requested report with ID = [%s] does not exist',
                $reportId
            );

            throw new NotFoundHttpException($message);
        }

        return new BinaryFileResponse(
            file: $this->reportStorage->getAbsolutePath(basename($report->path)),
            contentDisposition: ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
    }
}
