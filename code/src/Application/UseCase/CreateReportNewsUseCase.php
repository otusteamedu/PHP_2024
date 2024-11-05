<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase;

use Irayu\Hw15\Domain;

class CreateReportNewsUseCase
{
    public function __construct(
        private readonly Domain\Repository\NewsRepositoryInterface $newsRepository,
        private readonly Domain\Repository\ReportRepositoryInterface $reportRepository,
    ) {
    }

    public function __invoke(Request\CreateReportNewsItemRequest $request): Response\CreateReportNewsItemResponse
    {
        $newsItems = [];
        foreach ($request->ids as $id) {
            if ($news = $this->newsRepository->findById((int) $id)) {
                $newsItems[] = $news;
            }
        }
        $report = new Domain\Entity\Report($newsItems);
        $this->reportRepository->save($report);

        return new Response\CreateReportNewsItemResponse(
            $report->getHash(),
        );
    }
}
