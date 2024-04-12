<?php

declare(strict_types=1);

namespace App\News\Application\UseCase;

use App\News\Domain\Repository\NewsRepositoryInterface;

class GetAllNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function __invoke(): array
    {
        return $this->newsRepository->findAll();
    }
}