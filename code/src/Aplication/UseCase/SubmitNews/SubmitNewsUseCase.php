<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\UseCase\SubmitNews;

use Asyrovatkin\Hw14\Aplication\WebParser\WebParserInterface;
use Asyrovatkin\Hw14\Aplication\WebParser\WebParserRequest;
use Asyrovatkin\Hw14\Domain\Factory\NewsFactoryInterface;
use Asyrovatkin\Hw14\Domain\Repository\NewsRepositoryInterface;

class SubmitNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly WebParserInterface $webParser)
    {
    }

    public function __invoke(SubmitNewsRequest $request): SubmitNewsResponse
    {
        $news = $this->newsFactory->create($request->url);
        $webParserRequest = new WebParserRequest($news->getUrl());
        $webParserResponse = $this->webParser->parse($webParserRequest);
        $news->setTitle($webParserResponse->getName());
        $newsWithId = $this->newsRepository->save($news);
        return new SubmitNewsResponse($newsWithId);
    }

}