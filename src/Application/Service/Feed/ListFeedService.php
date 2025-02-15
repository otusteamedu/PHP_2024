<?php

namespace App\Application\Service\Feed;

use App\Domain\Entity\Feed;
use App\Domain\Repository\FeedAllParameters;
use App\Domain\Repository\FeedRepositoryInterface;

readonly class ListFeedService
{
    public function __construct(
        private FeedRepositoryInterface $feedRepository,
    ) {
    }

    /**
     * @return Feed[]
     */
    public function execute(FeedAllParameters $request): array
    {
        return $this->feedRepository->getAll($request);
    }
}
