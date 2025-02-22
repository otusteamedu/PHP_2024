<?php

namespace App\Infrastructure\Controller\Payload;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ListFeedRequest
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(100)]
        public int $limit = 10,
        #[Assert\GreaterThanOrEqual(1)]
        public int $page = 1,
    ) {
    }
}
