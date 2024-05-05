<?php

declare(strict_types=1);

namespace App\Application\UseCase\News;

use App\Application\UseCase\News\DTO\ListNewsResponse;
use App\Domain\Entity\News\NewsRepositoryInterface;

class ListNewsUseCase
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    public function __invoke(): ListNewsResponse
    {
        return new ListNewsResponse($this->newsRepository->all());
    }
}
