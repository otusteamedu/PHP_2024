<?php

namespace App\Application\Service\Feed;

use App\Application\GeneratorReport\ReportGeneratorInterface;
use App\Application\GeneratorReport\ReportGeneratorRequest;
use App\Application\Service\Feed\DTO\ReportFeedRequest;
use App\Application\Service\Feed\DTO\ReportFeedResponse;
use App\Domain\Repository\FeedRepositoryInterface;

readonly class ReportFeedService
{
    public function __construct(
        private FeedRepositoryInterface $feedRepository,
        private ReportGeneratorInterface $reportGenerator,
    ) {
    }

    public function execute(ReportFeedRequest $request): ReportFeedResponse
    {
        $feeds = $this->feedRepository->findByIds($request->ids);
        $reportRequest = [];
        foreach ($feeds as $feed) {
            $reportRequest[] = new ReportGeneratorRequest(
                $feed->getUrl(),
                $feed->getTitle(),
            );
        }
        $reportGeneratorResponse = $this->reportGenerator->generateReport($reportRequest);

        return new ReportFeedResponse($reportGeneratorResponse->fileName);
    }
}
