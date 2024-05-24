<?php

declare(strict_types=1);

namespace App\Application\Response;

readonly class EventResponse
{
    public function __construct(public string $event, public int $priority, public array $condition)
    {
    }
}