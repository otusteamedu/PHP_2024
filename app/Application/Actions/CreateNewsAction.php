<?php

namespace App\Application\Actions;

use App\Application\Requests\CreateNewsRequest;
use App\Application\Responses\CreateNewsResponse;
use App\Application\Services\HtmlCrawlerService;
use App\Domain\Factories\NewsFactoryInterface;

readonly class CreateNewsAction
{
    public function __construct(
        private NewsFactoryInterface $newsFactory
    ) {}

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        //        $date = date('d-m-y');
        //        $title = (new HtmlCrawlerService($request->url))->extractTextFromTag('title');
        //
        //        $news = $this->newsFactory->create(null, $date, $request->url, $title);
        //
        //        return new CreateNewsResponse($news->getId());
    }
}
