<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\DTO\NewsDTO;

readonly class GetAllNewsResponse
{
    /**
     * @var NewsDTO[] $news
     */
    public function __construct(public array $news)
    {
    }
}
