<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class CreateNewsResponse
{
    public function __construct(public int $id)
    {
    }
}
