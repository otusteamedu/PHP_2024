<?php

declare(strict_types=1);

namespace App\Application\Gateway\Response;

readonly class NewsResponse
{
    public function __construct(public string $html)
    {
    }
}
