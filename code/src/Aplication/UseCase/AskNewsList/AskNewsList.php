<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\UseCase\AskNewsList;

use Asyrovatkin\Hw14\Domain\Repository\NewsRepositoryInterface;

class AskNewsList
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    )
    {
    }

    public function __invoke(): AskNewsListResponse
    {
        return new AskNewsListResponse($this->newsRepository->findAll());
    }
}