<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase;

use Irayu\Hw15\Application\UseCase\Request\AddNewsItemRequest;
use Irayu\Hw15\Application\UseCase\Response\AddNewsItemResponse;

use Irayu\Hw15\Domain;

class AddNewsUseCase
{

    public function __construct(
        private Domain\Repository\NewsRepositoryInterface $newsRepository,
    )
    {
    }

    public function __invoke(AddNewsItemRequest $request): AddNewsItemResponse
    {
        $item = new Domain\Entity\NewsItem(
            new Domain\ValueObject\Url($request->url),
            new Domain\ValueObject\Title($request->title),
            new Domain\ValueObject\Date($request->date),
        );
        $this->newsRepository->save($item);

        return new AddNewsItemResponse(
            $item->getId(),
        );
    }
}