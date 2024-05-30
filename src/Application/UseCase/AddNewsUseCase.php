<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Exception\PageTitleNotFoundException;
use App\Application\Service\ArticleParserInterface;
use App\Application\Service\DTO\ParseArticleDto;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Application\UseCase\Response\DTO\AddedNewsDto;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use DateTimeImmutable;

class AddNewsUseCase
{

    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ArticleParserInterface  $getPageTitle,
    ) {
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $url = new Url($request->url);

        $article = $this->getPageTitle->parseArticle(new ParseArticleDto($url));

        if (is_null($article->title)) {
            throw new PageTitleNotFoundException();
        }

        $news = new News(
            new Title($article->title),
            $url,
            new DateTimeImmutable()
        );;

        $this->newsRepository->save($news);

        return new AddNewsResponse(new AddedNewsDto($news->getId()));
    }
}
