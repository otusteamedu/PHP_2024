<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Repository\NewsInterface;
use App\Domain\Entity\News;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;
use App\Domain\Dom\DocumentInterface;

class CreateNews
{
    public function __construct(
        private NewsInterface $newsRepository,
        private DocumentInterface $document
    ) {}

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $title = $this->document->getTitleByUrl($request->url);

        $news = new News(
            new Url($request->url),
            new Title($title)
        );

        $this->newsRepository->save($news);

        return new CreateNewsResponse($news->getId());
    }
}
