<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class MatchEventHttpRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('array')]
        public array $condition
    ) {
    }
}