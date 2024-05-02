<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\GetNewsListResponse;
use App\Domain\Interface\NewsRepositoryInterface;
use App\Domain\Interface\NormalizerInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(): GetNewsListResponse
    {
        $newsList = [];
        foreach ($this->newsRepository->getNewsList() as $news) {
            $newsList[] = $this->normalizer->normalize($news);
        }

        return new GetNewsListResponse($newsList);
    }
}
