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

class MakeReportUseCase
{

    public function __construct(
        private NewsRepositoryInterface $newsRepository,
        private ReportMakerInterface $reportMaker
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

        return new ConsolidatedReportResponse($this->reportMaker->makeReport($newsItems));
    }
}