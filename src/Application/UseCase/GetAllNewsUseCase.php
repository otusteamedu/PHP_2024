<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\GetAllNewsResponse;
use App\Domain\Repository\NewsRepositoryInterface;

readonly class GetAllNewsUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(): GetAllNewsResponse
    {
        $newsEntities = $this->newsRepository->findAll();

        return new GetAllNewsResponse(array_map(fn($news) => $news->toArray(), $newsEntities));
    }
}
