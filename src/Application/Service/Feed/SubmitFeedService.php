<?php

namespace App\Application\Service\Feed;

use App\Application\Gateway\UrlGatewayInterface;
use App\Application\Gateway\UrlGatewayRequest;
use App\Application\Service\Feed\DTO\SubmitFeedRequest;
use App\Application\Service\Feed\DTO\SubmitFeedResponse;
use App\Domain\Factory\FeedFactoryInterface;
use App\Domain\Repository\FeedRepositoryInterface;
use DateTimeImmutable;

readonly class SubmitFeedService
{
    function __construct(
        private FeedFactoryInterface    $feedFactory,
        private FeedRepositoryInterface $feedRepository,
        private UrlGatewayInterface     $urlGateway,
    )
    {
    }

    public function execute(SubmitFeedRequest $request): SubmitFeedResponse
    {
        $urlGatewayRequest = new UrlGatewayRequest($request->url);
        $urlGatewayResponse = $this->urlGateway->getTitle($urlGatewayRequest);

        $feed = $this->feedFactory->create(new DateTimeImmutable(), $urlGatewayResponse->title, $request->url);

        $this->feedRepository->save($feed);

        return new SubmitFeedResponse($feed->getId());
    }
}
