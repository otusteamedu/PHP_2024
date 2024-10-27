<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetListNews;

use App\Application\UseCase\GetListNews\GetListNewsRequest;
use App\Application\UseCase\GetListNews\GetListNewsResponse;
use App\Domain\Output\NewsPrepareTextInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class GetListNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;
    private NewsPrepareTextInterface $newsOutputTextStrategy;
    public function __construct(
        NewsRepositoryInterface $newsRepository,
        NewsPrepareTextInterface $newsOutputTextStrategy
    )
    {
        $this->newsRepository = $newsRepository;
        $this->newsOutputTextStrategy = $newsOutputTextStrategy;
    }

    public function __invoke(GetListNewsRequest $request): GetListNewsResponse
    {
        $ans = [];
        $news_list = $this->newsRepository->findAll();
        foreach ($news_list AS $news) {
            $text = $this->newsOutputTextStrategy->prepareText($news); // :string
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