<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Request;

class ListNewsItemRequest implements DefaultNewsItemRequest
{
    public function __construct(
        public readonly ?int $pageNumber,
        public readonly ?int $pageSize,
    )
    {
    }
}