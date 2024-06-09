<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

final readonly class GetNewsResponse
{
    public function __construct(
        public int $id,
        public string $title,
        public string $date,
        public string $url,
    )
    {
    }
}
