<?php

namespace Application\UseCase\AddNews;

use Application\Gateway\NewsGatewayInterface;
use Application\Gateway\NewsGatewayRequest;
use Domain\Factory\NewsFactoryInterface;
use Domain\Repository\NewsRepositoryInterface;

class AddNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface    $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly NewsGatewayInterface    $newsGateway
    )
    {
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        // Загрузить новость и получить ее заголовок
        $newsGatewayRequest = new NewsGatewayRequest($request->url);
        $newsGatewayResponse = $this->newsGateway->readNews($newsGatewayRequest);

        // Создать News
        $news = $this->newsFactory->create($request->url, $newsGatewayResponse->title);

        // Сохранить в БД
        $this->newsRepository->save($news);

        // Сформировать и вернуть ответ
        return new AddNewsResponse($news->getId());
    }

}
