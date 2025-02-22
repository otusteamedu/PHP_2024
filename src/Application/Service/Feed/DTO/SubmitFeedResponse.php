<?php

namespace App\Application\Service\Feed\DTO;

use App\Domain\ValueObject\Id;

readonly class SubmitFeedResponse
{
    public function __construct(
        public Id $id,
    ) {
    }
}
