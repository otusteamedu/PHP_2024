<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class GetAllNewsResponse
{
    public function __construct(public array $news)
    {
    }
}
