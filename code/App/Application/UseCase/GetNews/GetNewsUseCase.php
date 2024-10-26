<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNews;

use App\Domain\Entity\News;
use App\Domain\Output\NewsPrepareTextInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;
    private NewsPrepareTextInterface $newsOutputText;
    public function __construct(
        NewsRepositoryInterface $newsRepository,
        NewsPrepareTextInterface $newsOutputText
    )
    {
        $this->newsRepository = $newsRepository;
        $this->newsOutputText = $newsOutputText;
    }

    public function __invoke(GetNewsRequest $request): GetNewsResponse
    {
        $news = $this->newsRepository->findById($request->id);
        $text = $this->newsOutputText->prepareText($news); // :string

        return new GetNewsResponse(
            1, $text
        );
    }
}