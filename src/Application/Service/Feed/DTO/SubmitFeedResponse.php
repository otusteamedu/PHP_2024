<?php

namespace App\Application\Service\Feed\DTO;

readonly class SubmitFeedResponse
{
    public function __construct(
        public int $id,
    ) {
    }
}
