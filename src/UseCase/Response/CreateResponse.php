<?php

declare(strict_types=1);

namespace App\UseCase\Response;

readonly class CreateResponse
{
    public function __construct(public string $id)
    {
    }
}
