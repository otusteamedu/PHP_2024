<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

class GetNewsUseCase
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    /**
     * @return News[]
     */
    public function __invoke(): array
    {
        return $this->newsRepository->findAll();
    }
}
