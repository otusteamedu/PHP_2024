<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing\Event;

class SearchEventQuery
{
    public function __construct(
        private readonly array $conditions,
    ) {
    }

    public function conditions(): array
    {
        return $this->conditions;
    }
}
