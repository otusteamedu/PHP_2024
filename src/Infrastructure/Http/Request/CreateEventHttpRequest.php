<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateEventHttpRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 255)]
        #[Assert\Type('string')]
        public string $event,
        #[Assert\NotBlank]
        #[Assert\LessThanOrEqual(value: 100_000)]
        #[Assert\GreaterThanOrEqual(value: 0)]
        #[Assert\Type('integer')]
        public int $priority,
        #[Assert\NotBlank]
        #[Assert\Type('array')]
        public array $condition
    ) {
    }
}