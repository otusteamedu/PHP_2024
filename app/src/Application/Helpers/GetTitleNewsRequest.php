<?php

declare(strict_types=1);

namespace App\Application\Helpers;

class GetTitleNewsRequest
{
    public function __construct(public readonly string $html)
    {
    }
}
