<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsGetListUseCase;

use App\Application\NewsProvider\Exception\NewsProviderNotSupportedException;
use App\Application\UseCase\NewsGetListUseCase\Boundary\NewsListResponse;
use App\Domain\Repository\NewsRepositoryInterface;

final readonly class NewsGetListUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
    ) {
    }

    /**
     * @throws NewsProviderNotSupportedException
     */
    public function __invoke(): NewsListResponse
    {
        return NewsListResponse::fromBoundary($this->newsRepository->findAll());
    }
}
