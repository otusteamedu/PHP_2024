<?php

namespace App\Infrastructure\Controller\Payload;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateFeedRequest
{
    function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $url,
    )
    {
    }
}
