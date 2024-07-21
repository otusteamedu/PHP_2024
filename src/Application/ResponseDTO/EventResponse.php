<?php

declare(strict_types=1);

namespace App\Application\ResponseDTO;

readonly class EventResponse
{
    public function __construct(public int $uid, public int $priority, public array $conditions)
    {
    }
}
