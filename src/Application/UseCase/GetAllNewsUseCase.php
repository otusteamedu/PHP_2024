<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\NewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

class GetAllNewsUseCase
{
    public function __construct(private readonly NewsRepositoryInterface $newsRepository)
    {
    }

    /**
     * @return NewsResponse[]
     */
    public function __invoke(): array
    {
        return array_map(
            static fn (News $news): NewsResponse => new NewsResponse(
                $news->getId(),
                $news->getUrl()->getValue(),
                $news->getTitle()->getValue(),
                $news->getCreatedDate()->format('Y-m-d H:i:s')),
            $this->newsRepository->getAll()
        );
    }
}