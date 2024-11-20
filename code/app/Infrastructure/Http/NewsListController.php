<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\NewsList\NewsListUseCase;
use Exception;

readonly class NewsListController
{
    public function __construct(
        private NewsListUseCase $newsListUseCase
    ) {
    }

    public function __invoke()
    {
        try {
            $response = ($this->newsListUseCase)();
        } catch (Exception) {
            return response('Server internal error', 500);
        }

        return response()->json($response);
    }
}
