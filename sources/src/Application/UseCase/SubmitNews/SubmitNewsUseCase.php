<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

use App\Application\Gateway\DomCrawler;
use App\Application\Gateway\DomCrawlerRequest;
use App\Domain\Factory\NewsFactory;
use App\Domain\Repository\NewsRepository;
use App\Domain\ValueObject\Url;
use DateTimeImmutable;

readonly class SubmitNewsUseCase
{
    public function __construct(
        private NewsRepository $repository,
        private NewsFactory    $factory,
        private DomCrawler     $crawler,
    )
    {
    }

    public function __invoke(SubmitNewsRequest $request): SubmitNewsResponse
    {
        // Допускается ли тут использовать VO ? Выглядит логично, т.к нет смысла далее передавать если это не url
        $urlTitle = $this->crawler->getTitle(new DomCrawlerRequest(new Url($request->url)));

        $news = $this->factory->create(
            $request->getUrl(),
            $urlTitle->getTitle(),
            new DateTimeImmutable()
        );

        $this->repository->save($news);

        return new SubmitNewsResponse($news->getId());
    }
}