<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\Create;

final readonly class CreateRequest
{
    public function __construct(public string $url)
    {
    }
}
