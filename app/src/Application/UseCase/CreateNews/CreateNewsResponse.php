<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNews;

class CreateNewsResponse
{
    public function __construct(public readonly int $id)
    {
    }
}
