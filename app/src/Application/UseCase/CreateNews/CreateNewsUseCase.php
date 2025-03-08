<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\CreateNews;

use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use DateTimeImmutable;


class CreateNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsParserInterface $newsParser,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        // Empty constructor
    }

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        //Prepare ValueObjects
        $url = new Url($request->url);
        $title = new Title($this->newsParser->parse($url));
        $date = new Date(new DateTimeImmutable());

        //Create news
        $news = $this->newsFactory->create($title, $date, $url);

        //Save news to DB
        $this->newsRepository->save($news);

        return new CreateNewsResponse($news->getId());
    }
}
