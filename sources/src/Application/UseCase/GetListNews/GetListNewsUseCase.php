<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetListNews;

use App\Domain\Repository\NewsRepository;

readonly class GetListNewsUseCase
{
    public function __construct(
        private NewsRepository $repository
    )
    {
    }

    public function __invoke(): GetListNewsResponse
    {
        $news = $this->repository->findAll();

        return new GetListNewsResponse($news);
    }
}