<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\ReportMakerInterface;
use App\Application\StaticFileStorageInterface;
use App\Application\UseCase\Request\MakeConsolidatedReportRequest;
use App\Application\UseCase\Response\ConsolidatedReportResponse;
use App\Domain\Exception\DomainException;
use App\Domain\Repository\NewsRepositoryInterface;

class MakeReportUseCase
{

    public function __construct(
        private NewsRepositoryInterface    $newsRepository,
        private ReportMakerInterface       $reportMaker,
        private StaticFileStorageInterface $fileStorage
    ) {}

    public function __invoke(MakeConsolidatedReportRequest $request)
    {
        if (empty($request->ids)) {
            throw new DomainException('Empty ids');
        }

        $newsList = $this->newsRepository->getByIds($request->ids);
        if (empty($newsList)) {
            throw new DomainException('News not found');
        }

        $content = $this->reportMaker->makeReport($newsList);
        if (empty($content)) {
            throw new DomainException('Failed to create consolidated report');
        }

        $fileName = 'report_' . time() . '.html';
        $this->fileStorage->saveReportFile($fileName, $content);

        return new ConsolidatedReportResponse($this->fileStorage->getStaticReportFileUriPath($fileName));
    }
}