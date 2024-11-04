<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNews;

use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Application\Gateway\SiteGatewayInterface;
use App\Application\Helpers\GetTitleInterface;
use App\Application\Gateway\SiteGatewayRequest;
use App\Application\Helpers\GetTitleNewsRequest;

class CreateNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly SiteGatewayInterface $siteGateway,
        private readonly GetTitleInterface $getTitle
    ) {
    }

    // обращаемся к объектам как к функциям
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $siteGatewayRequest = new SiteGatewayRequest($request->url);
        $siteGatewayResponse = $this->siteGateway->getHtml($siteGatewayRequest);
        $getTitleRequest = new GetTitleNewsRequest($siteGatewayResponse->html);
        $getTitleResponse = $this->getTitle->getTitle($getTitleRequest);

        //создать новость
        $news = $this->newsFactory->create($request->url, $getTitleResponse->title);

        $this->newsRepository->save($news);

        //вернуть результат (ID)
        return new CreateNewsResponse($news->getId());
    }
}
