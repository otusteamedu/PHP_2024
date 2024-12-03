<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

use App\Application\Gateway\NewsGatewayInterface;
use App\Application\Gateway\NewsGatewayRequest;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class SubmitNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly NewsGatewayInterface $newsGateway,
    ) {
    }
    public function __invoke(SubmitNewsRequest $request): SubmitNewsResponse
    {
        $newsGatewayRequest = new NewsGatewayRequest($request->url);
        $newsGatewayResponse = $this->newsGateway->getNews($newsGatewayRequest);

        $news = $this->newsFactory->create($newsGatewayResponse->title, $newsGatewayResponse->url, $newsGatewayResponse->date);

        $this->newsRepository->save($news);

        return new SubmitNewsResponse(
            $news->getId(),
        );
    }
}
