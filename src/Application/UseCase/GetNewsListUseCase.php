<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\DTO\NewsResponseDto;
use App\Application\UseCase\Response\GetNewsListResponse;
use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(): GetNewsListResponse
    {
        $newsList = [];

        foreach ($this->newsRepository->findAll() as $news) {
            $newsList[] = new NewsResponseDto(
                $news->getId(),
                $news->getCreatedAt()->format('Y-m-d'),
                $news->getUrl()->getValue(),
                $news->getTitle()->getValue(),
            );
        }

        return new GetNewsListResponse($newsList);
    }
}
