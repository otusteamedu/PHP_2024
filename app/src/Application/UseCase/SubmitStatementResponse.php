<?php

declare(strict_types=1);

namespace App\Application\UseCase;

class SubmitStatementResponse
{
    public function __construct(public int $id)
    {
    }
}
