<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNews;

use App\Domain\Entity\News;
use App\Domain\Output\AppendedTextInterface;
use App\Domain\Output\NewsPrepareTextInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;
    private NewsPrepareTextInterface $newsOutputTextStrategy;
    private AppendedTextInterface $newsOutputTextDecorator;
    public function __construct(
        NewsRepositoryInterface $newsRepository,
        NewsPrepareTextInterface $newsOutputTextStrategy,
        AppendedTextInterface $newsOutputTextDecorator
    )
    {
        $this->newsRepository = $newsRepository;
        $this->newsOutputTextStrategy = $newsOutputTextStrategy;
        $this->newsOutputTextDecorator = $newsOutputTextDecorator;
    }

    public function __invoke(GetNewsRequest $request): GetNewsResponse
    {
        $news = $this->newsRepository->findById($request->id);
        $text = $this->newsOutputTextStrategy->prepareText($news); // :string

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