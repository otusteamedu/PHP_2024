<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class CreateNewsRequest
{
    public function __construct(public string $url)
    {
    }
}
