<?php

declare(strict_types=1);

namespace App\Application\UseCase;

class GetStatusStatementRequest
{
    public function __construct(public readonly int $id)
    {
    }
}
