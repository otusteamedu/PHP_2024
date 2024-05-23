<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\Create;

final readonly class CreateResponse
{
    public function __construct(public string $id)
    {
    }
}
