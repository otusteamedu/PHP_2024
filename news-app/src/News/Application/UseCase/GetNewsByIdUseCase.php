<?php

declare(strict_types=1);

namespace App\News\Application\UseCase;

use App\News\Domain\Entity\News;
use App\News\Domain\Repository\NewsRepositoryInterface;

class GetNewsByIdUseCase
{
    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function __invoke(int $id): ?News
    {
        return $this->newsRepository->findById($id);
    }
}