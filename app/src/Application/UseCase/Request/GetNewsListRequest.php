<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class GetNewsListRequest
{
    public function __construct(public int $offset = 0, public int $limit = 10)
    {
    }
}
