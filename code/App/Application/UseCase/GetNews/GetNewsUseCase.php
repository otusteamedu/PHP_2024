<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNews;

use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Strategy\NewsStrategyInterface;

class GetNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;
    private NewsStrategyInterface $newsStrategy;
    public function __construct(
        NewsRepositoryInterface $newsRepository,
        NewsStrategyInterface $newsStrategy
    )
    {
        $this->newsRepository = $newsRepository;
        $this->newsStrategy = $newsStrategy;
    }

    public function __invoke(GetNewsRequest $request): GetNewsResponse
    {
        $news = $this->newsRepository->findById($request->id);
        $text = $this->newsStrategy->getText($news);

        return new GetNewsResponse(
            $news->getId(),
            $text,
            $news->getDateCreated()->format('d.m.Y'),
            $news->getAuthor()->getValue(),
            $news->getCategory()->getValue(),
            $news->getName()->getValue(),
        );
    }
}