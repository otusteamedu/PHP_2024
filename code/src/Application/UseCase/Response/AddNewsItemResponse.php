<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Response;

class AddNewsItemResponse implements DefaultNewsItemResponse
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
