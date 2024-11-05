<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase;

use Irayu\Hw15\Application\UseCase\Request\AddNewsItemRequest;
use Irayu\Hw15\Application\UseCase\Response\AddNewsItemResponse;
use Irayu\Hw15\Domain;
use Irayu\Hw15\Application\Gateway;

class AddNewsItemUseCase
{
    public function __construct(
        private readonly Domain\Factory\NewsItemFactoryInterface $newsItemFactory,
        private readonly Domain\Repository\NewsRepositoryInterface $newsItemRepository,
        private readonly Gateway\UrlLoaderInterface $urlLoader,
    ) {
    }

    public function __invoke(AddNewsItemRequest $request): AddNewsItemResponse
    {
        // Скачать ресурс
        $urlLoaderRequest = new Gateway\UrlLoaderRequest($request->url);
        $urlLoaderResponse = $this->urlLoader->getContent($urlLoaderRequest);

        // Вот так ожидается увидеть:
        if (true) {
            $item = $this->newsItemFactory->create(
                $request->url,
                $urlLoaderResponse->title,
                $urlLoaderResponse->dateTime,
            );
        } else {
            // Но почему не сделать так? Тут нужно заменить на фабрику из слоя приложения:
            $item = new Domain\Entity\NewsItem(
                new Domain\ValueObject\Url($request->url),
                new Domain\ValueObject\Title($urlLoaderResponse->title),
                new Domain\ValueObject\Date($urlLoaderResponse->dateTime),
            );
        }

        $this->newsItemRepository->save($item);

        return new AddNewsItemResponse(
            $item->getId(),
        );
    }
}
