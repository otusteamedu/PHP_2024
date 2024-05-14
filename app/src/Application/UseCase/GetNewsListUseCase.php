<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\GetNewsListRequest;
use App\Application\UseCase\Response\GetNewsListResponse;
use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsListUseCase
{
    public function __construct(private readonly NewsRepositoryInterface $newsRepository)
    {
    }

    public function __invoke(GetNewsListRequest $request): GetNewsListResponse
    {
        $news = $this->newsRepository->findAllNews($request->offset, $request->limit);

        return new GetNewsListResponse($news);
    }
}
