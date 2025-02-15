<?php

namespace App\Application\Service\Feed\DTO;

class ReportFeedRequest
{
    public function __construct(
        /** @var int[] $ids */
        public array $ids,
    ) {
    }
}
