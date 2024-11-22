<?php

namespace App\Controller\Http\News\Create\v1;

use App\Controller\Validator\UniqueUrl;
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
