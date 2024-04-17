<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\GetNewsRequest;
use App\Application\UseCase\Response\GetNewsResponse;
use App\Domain\Repository\NewsInterface;
use Exception;

class GetNews
{
    public function __construct(
        private readonly NewsInterface $newsRepository
    ) {} // phpcs:ignore

    /**
     * @param GetNewsRequest $request
     * @return GetNewsResponse
     * @throws Exception
     */
    public function __invoke(GetNewsRequest $request): GetNewsResponse
    {
        $news = $this->newsRepository->findByParams(['id' => $request->id]);

        if (empty($news)) {
            throw new Exception('News not found');
        }

        return new GetNewsResponse($news[0]->getStatus());
    }
}
