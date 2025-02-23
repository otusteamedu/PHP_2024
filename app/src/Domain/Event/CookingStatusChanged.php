<?php

namespace Otus\Hw16\Domain\Event;

class CookingStatusChanged
{
    public function __construct(private string $status)
    {
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
