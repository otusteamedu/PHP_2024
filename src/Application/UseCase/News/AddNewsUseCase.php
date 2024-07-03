<?php

declare(strict_types=1);

namespace App\Application\UseCase\News;

use App\Application\UseCase\News\DTO\StoreNewsRequest;
use App\Domain\Entity\News\{News, NewsMapper};
use App\Domain\ValueObject\{NewsTitle, Url};

class AddNewsUseCase
{
    public function __construct(private NewsMapper $newsMapper)
    {
    }

    public function __invoke(StoreNewsRequest $request): int
    {
        $news = new News(new Url($request->url), new NewsTitle($request->title));

        $this->newsMapper->save($news);

        return $news->getId();
    }
}
