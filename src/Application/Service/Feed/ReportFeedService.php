<?php

namespace App\Application\Service\Feed;

use App\Application\Service\Feed\DTO\ReportFeedRequest;
use App\Application\Service\Feed\DTO\ReportFeedResponse;
use App\Domain\Repository\FeedFileRepositoryInterface;
use App\Domain\Repository\FeedRepositoryInterface;

readonly class ReportFeedService
{

    function __construct(
        private FeedRepositoryInterface $feedRepository,
        private FeedFileRepositoryInterface $feedFileRepository,
    )
    {
    }

    public function execute(ReportFeedRequest $request): ReportFeedResponse
    {
        $feeds = $this->feedRepository->findByIds($request->ids);

        $file = $this->feedFileRepository->saveReport($feeds);

        return new ReportFeedResponse($file);
    }
}
