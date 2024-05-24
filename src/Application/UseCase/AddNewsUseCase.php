<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\ContentDownloader\ContentDownloaderInterface;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Request\ContentDownloaderRequest;
use App\Application\UseCase\Request\HtmParseRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Exception\DomainException;
use App\Domain\ObjectValue\Title;
use App\Domain\ObjectValue\Url;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Parser\HtmlParser;

readonly class AddNewsUseCase
{
    public function __construct(
        private ContentDownloaderInterface $contentDownloader,
        private HtmlParser                 $htmlParser,
        private NewsRepositoryInterface    $newsRepository
    ) {}

    /**
     * @throws DomainException
     */
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $url = new Url($request->url);
        $downloadReq = new ContentDownloaderRequest($url->getValue());
        $downloadRes = $this->contentDownloader->download($downloadReq);
        $parseReq = new HtmParseRequest($downloadRes->content);
        $parseRes = $this->htmlParser->parseTitle($parseReq);

        $news = new News(new Title($parseRes->title), $url);
        $this->newsRepository->save($news);

        return new AddNewsResponse($news->getId());
    }
}