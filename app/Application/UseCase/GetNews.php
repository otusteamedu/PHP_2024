<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\GetNewsResponse;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\News;

final class GetNews
{
    public function __construct(private readonly RepositoryInterface $repository)
    {
    }

    public function __invoke(): array
    {
        return array_map(function (News $news) {
            return new GetNewsResponse(
                $news->getId(),
                $news->getTitle(),
                $news->getDate(),
                $news->getUrl()
            );
        }, $this->repository->getAll());
    }
}
