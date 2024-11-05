<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Request;

class AddNewsItemRequest implements DefaultNewsItemRequest
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}
