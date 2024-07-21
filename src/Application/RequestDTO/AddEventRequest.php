<?php

declare(strict_types=1);

namespace App\Application\RequestDTO;

readonly class AddEventRequest
{
    public function __construct(public int $priority, public array $conditions)
    {
    }
}
