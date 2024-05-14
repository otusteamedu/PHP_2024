<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\Service\UseCaseResponseInterface;

readonly class GetNewsListResponse implements UseCaseResponseInterface
{
    public function __construct(private array $news)
    {
    }

    public function getData(): mixed
    {
        return $this->news;
    }
}
