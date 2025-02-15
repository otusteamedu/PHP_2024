<?php

namespace App\Application\Service\Feed\DTO;

class ReportFeedRequest
{
    function __construct(
        /** @var int[] $ids */
        public array $ids,
    )
    {
    }
}
