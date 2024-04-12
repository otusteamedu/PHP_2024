<?php
declare(strict_types=1);

namespace App\Application\UseCase\NewsCreateUseCase;

use App\Application\NewsProvider\Exception\NewsProviderNotSupportedException;
use App\Application\NewsProvider\NewsProviderRegistryInterface;
use App\Application\UseCase\NewsGetListUseCase\Boundary\NewsCreateResponse;
use App\Domain\Repository\NewsRepositoryInterface;

final readonly class NewsCreateUseCase
{
    public function __construct(
        private NewsProviderRegistryInterface $newsProviderRegistry,
        private NewsRepositoryInterface $newsRepository,
    )
    {
    }

    /**
     * @param array $newsDeterminationAttributes
     * @return NewsCreateResponse
     *
     * @throws NewsProviderNotSupportedException
     */
    public function __invoke(array $newsDeterminationAttributes): NewsCreateResponse
    {
        $news = $this->newsProviderRegistry->retrieveNews($newsDeterminationAttributes);

        $this->newsRepository->save($news);

        return NewsCreateResponse::fromBoundary($news);
    }
}
