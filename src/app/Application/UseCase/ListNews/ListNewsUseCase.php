<?php

namespace App\Application\UseCase\ListNews;

use App\Domain\Repository\NewsRepositoryInterface;

class ListNewsUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $repository
    )
    {
    }

    public function __invoke(): ListNewsResponse
    {
        $news = $this->repository->get();
        return new ListNewsResponse($news);
    }
}
