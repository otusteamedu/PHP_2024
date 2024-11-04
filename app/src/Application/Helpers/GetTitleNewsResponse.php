<?php

declare(strict_types=1);

namespace App\Application\Helpers;

class GetTitleNewsResponse
{
    public function __construct(public readonly string $title)
    {
    }
}
