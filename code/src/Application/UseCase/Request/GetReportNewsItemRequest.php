<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Request;

class GetReportNewsItemRequest implements DefaultNewsItemRequest
{
    public function __construct(
        public readonly int $id,
        public readonly string $hash,
    ) {}
}
