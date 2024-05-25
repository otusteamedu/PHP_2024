<?php

declare(strict_types=1);

namespace App\Application\UseCase\News;

use App\Application\UseCase\News\DTO\StoreNewsRequest;
use App\Domain\Entity\News\{News, NewsRepositoryInterface};
use App\Domain\ValueObject\{NewsTitle, Url};

class AddNewsUseCase
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    public function __invoke(StoreNewsRequest $request): int
    {
        $news = new News(new Url($request->url), new NewsTitle($request->title));

        $this->newsRepository->save($news);

        return $news->getId();
    }
}
