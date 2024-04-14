<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\ContentDownloaderInterface;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Exception\DomainException;
use App\Domain\ObjectValue\Title;
use App\Domain\ObjectValue\Url;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\HtmlParser;

class AddNewsUseCase
{
    public function __construct(
        private ContentDownloaderInterface $contentDownloader,
        private HtmlParser $htmlParser,
        private NewsRepositoryInterface $newsRepository
    ) {}

    /**
     * @throws DomainException
     */
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $url = new Url($request->url);
        $content = $this->contentDownloader->download($url->getValue());
        $title = $this->htmlParser->parseTitle($content);

        $news = new News(new Title($title), $url);
        $this->newsRepository->save($news);

        return new AddNewsResponse($news->getId());
    }
}