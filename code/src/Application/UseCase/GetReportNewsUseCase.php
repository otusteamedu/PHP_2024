<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase;

use Irayu\Hw15\Domain;

class GetReportNewsUseCase
{
    public function __construct(
        private readonly Domain\Repository\NewsRepositoryInterface $newsRepository,
        private readonly Domain\Repository\ReportRepositoryInterface $reportRepository,
    )
    {
    }

    public function __invoke(Request\GetReportNewsItemRequest $request): Response\GetReportNewsItemResponse
    {
        $newsItems = [];

        if (($report = $this->reportRepository->findById($request->id))
            && $report->getHash() === $request->hash
        ) {
            $newsItems = [];
            foreach ($report->getNewsItemIds() as $newsItemId) {
                if ($news = $this->newsRepository->findById((int)$newsItemId))
                {
                    $newsItems[] = $news;
                }
            }
        }

        return new Response\GetReportNewsItemResponse(
            $report,
            $newsItems,
        );
    }
}
