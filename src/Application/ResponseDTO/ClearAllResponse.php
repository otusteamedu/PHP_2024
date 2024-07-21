<?php

declare(strict_types=1);

namespace App\Application\ResponseDTO;

readonly class ClearAllResponse
{
    public function __construct(public bool $success)
    {
    }
}
