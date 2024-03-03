<?php

declare(strict_types=1);

namespace App\Request;

final readonly class CheckParenthesesRequest
{
    public function __construct(public string $string)
    {
    }
}
