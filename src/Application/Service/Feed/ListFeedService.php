<?php

namespace App\Application\Service\Feed;

use App\Application\Service\Feed\DTO\ListFeetResponse;
use App\Domain\Repository\PaginationParams;
use App\Domain\Repository\FeedRepositoryInterface;

readonly class ListFeedService
{
    public function __construct(
        private FeedRepositoryInterface $feedRepository,
    ) {
    }

    /**
     * @return ListFeetResponse[]
     */
    public function execute(PaginationParams $request): array
    {
        $feeds = $this->feedRepository->getAll($request);
        $listFeed = [];
        foreach ($feeds as $feed) {
            $listFeed[] = new ListFeetResponse(
                $feed->getId(),
                $feed->getDate(),
                $feed->getUrl(),
                $feed->getTitle(),
            );
        }

        return $listFeed;
    }
}
