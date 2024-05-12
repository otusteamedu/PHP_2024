<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Request;

class CreateReportNewsItemRequest implements DefaultNewsItemRequest
{
    public function __construct(
        public readonly array $ids,
    )
    {
    }
}