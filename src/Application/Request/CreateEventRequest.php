<?php

declare(strict_types=1);

namespace App\Application\Request;

readonly class CreateEventRequest
{
    public function __construct(public string $event, public int $priority, public array $condition)
    {
    }
}