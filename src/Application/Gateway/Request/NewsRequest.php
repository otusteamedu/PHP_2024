<?php

declare(strict_types=1);

namespace App\Application\Gateway\Request;

readonly class NewsRequest
{
    public function __construct(public string $url)
    {
    }
}
