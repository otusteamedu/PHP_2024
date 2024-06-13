<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\News;

use AlexanderGladkov\CleanArchitecture\Application\Factory\NewsDtoFactory;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Dto\NewsDto;
use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;

class GetNewsUseCase
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    /**
     * @return NewsDto[]
     */
    public function __invoke(): array
    {
        $news = $this->newsRepository->findAll();
        return (new NewsDtoFactory())->createFromNewsList($news);
    }
}
