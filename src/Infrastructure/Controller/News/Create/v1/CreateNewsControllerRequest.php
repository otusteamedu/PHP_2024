<?php

namespace App\Infrastructure\Controller\News\Create\v1;

use App\Infrastructure\Validator\UniqueUrl;
use Symfony\Component\Validator\Constraints as Assert;

class CreateNewsControllerRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[UniqueUrl]
        public readonly string $url,
    ) {
    }
}
