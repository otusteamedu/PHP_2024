<?php

namespace App\Application\Actions;

use App\Application\Requests\CreateNewsRequest;
use App\Application\Responses\CreateNewsResponse;
use App\Application\Services\HtmlCrawlerService;
use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Repositories\NewsRepositoryInterface;

readonly class CreateNewsAction
{
    public function __construct(
        private NewsFactoryInterface $newsFactory,
        private NewsRepositoryInterface $newsRepository
    ) {}

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $date = date('d-m-y');
        $title = (new HtmlCrawlerService($request->url))->extractTextFromTag('title');

        $newsEntity = $this->newsFactory->create($date, $request->url, $title);

        $this->newsRepository->save($newsEntity);

        return new CreateNewsResponse($newsEntity->getId());
    }
}
