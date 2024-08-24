<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\NewsList\NewsListUseCase;
use App\Infrastructure\Factory\NewsLoader;

class NewsListController
{
    public function __construct(
        private NewsListUseCase $newsListUseCase
    ) {}


    public function __invoke()
    {
        $result = [];

        try {
            $response = ($this->newsListUseCase)();
            foreach ($response->newsList as $news) {
                $result[] = [
                    'id' => $news->getId(),
                    'title' => $news->getTitle()->getValue(),
                    'url' => $news->getUrl()->getValue(),
                    'exportDate' => $news->getExportDate()->getValue()->format('Y-m-d'),
                ];
            }
        } catch (\Exception) {
            return response('Server internal error', 500);
        }

        return response()->json($result);
    }
}
