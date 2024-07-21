<?php

declare(strict_types=1);

namespace App\Application\RequestDTO;

readonly class FindEventRequest
{
    public function __construct(public array $conditions)
    {
    }
}
