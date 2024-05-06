<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\ReportMaker\ReportMakerInterface;
use App\Application\UseCase\Request\MakeConsolidatedReportRequest;
use App\Application\UseCase\Request\NewsItemRequest;
use App\Application\UseCase\Response\ConsolidatedReportResponse;
use App\Domain\Entity\News;
use App\Domain\Exception\DomainException;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\StaticFileStorage\StaticFileStorageInterface;

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

        $newsItems = array_map(
            static fn (News $item) => new NewsItemRequest($item->getUrl()->getValue(), $item->getTitle()->getValue()),
            $newsList
        );

        $content = $this->reportMaker->makeReport($newsItems);
        if (empty($content)) {
            throw new DomainException('Failed to create consolidated report');
        }

        return new ConsolidatedReportResponse($this->fileStorage->saveReportFile($content));
    }
}