<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetListNews;

use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Strategy\NewsStrategyInterface;

class GetListNewsUseCase
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

    public function __invoke(GetListNewsRequest $request): GetListNewsResponse
    {
        $ans = [];
        $news_list = $this->newsRepository->findAll();
        foreach ($news_list AS $news) {
            $text = $this->newsStrategy->getText($news); // :string
            $ans[] = [
                'id' => $news->getId(),
                'text' => $text,
                'date_created' => $news->getDateCreated()->format('d.m.Y'),
                'author' => $news->getAuthor()->getValue(),
                'category' => $news->getCategory()->getValue(),
                'name' => $news->getName()->getValue(),
            ];
        }

        return new GetListNewsResponse($ans);
    }
}