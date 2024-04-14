<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class AddNewsRequest
{
    public function __construct(public readonly string $url)
    {
    }
}