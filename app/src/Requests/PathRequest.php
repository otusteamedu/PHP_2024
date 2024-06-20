<?php

declare(strict_types=1);

namespace App\src\Requests;

class PathRequest
{
    public function __construct(public string $path)
    {
    }
}
