<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class NewsGatewayResponse
{
    public function __construct(
        public readonly string $title,
        public readonly string $url,
        public readonly \DateTimeImmutable $date,
    ) {
    }
}
