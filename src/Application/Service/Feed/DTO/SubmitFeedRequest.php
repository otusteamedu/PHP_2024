<?php

namespace App\Application\Service\Feed\DTO;

readonly class SubmitFeedRequest
{
    function __construct(
        public string $url,
    )
    {
    }
}
