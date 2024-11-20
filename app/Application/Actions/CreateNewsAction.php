<?php

namespace App\Application\Actions;

use App\Application\Requests\CreateNewsRequest;
use App\Application\Responses\CreateNewsResponse;
use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Repositories\NewsRepositoryInterface;
use App\Domain\Services\UrlParserInterface;

class CreateNewsAction
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly UrlParserInterface $urlParser
    ) {
    }

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $date = date('d-m-y');

        $title = $this->urlParser->extractText($request->url, 'title');

        $newsEntity = $this->newsFactory->create($date, $request->url, $title);

        $this->newsRepository->save($newsEntity);

        return new CreateNewsResponse($newsEntity->getId());
    }
}
