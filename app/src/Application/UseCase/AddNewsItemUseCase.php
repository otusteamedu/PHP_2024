<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Bus\Dto\NewsItemUrlBusRequestDto;
use App\Application\Bus\NewsItemUrlBusInterface;
use App\Application\UseCase\Dto\SubmitNewsItemRequestDto;
use App\Application\UseCase\Dto\SubmitNewsItemResponseDto;
use App\Domain\Factory\NewsItemFactoryInterface;
use App\Domain\Repository\NewsItemRepositoryInterface;

class AddNewsItemUseCase
{
    public function __construct(
        private readonly NewsItemFactoryInterface $newsItemFactory,
        private readonly NewsItemRepositoryInterface $newsItemRepository,
        private readonly NewsItemUrlBusInterface $newsItemUrlBus,
    ) {
    }

    public function __invoke(SubmitNewsItemRequestDto $requestDto): SubmitNewsItemResponseDto
    {
        $newsItemUrlBusRequestDto = new NewsItemUrlBusRequestDto($requestDto->url);
        $newsItemUrlBusResponseDto = $this->newsItemUrlBus->getNewsItemByUrl($newsItemUrlBusRequestDto);

        $newsItem = $this->newsItemFactory->create(
            $newsItemUrlBusResponseDto->title,
            $newsItemUrlBusResponseDto->url,
            $newsItemUrlBusResponseDto->date,
        );

        $this->newsItemRepository->save($newsItem);

        return new SubmitNewsItemResponseDto(
            $newsItem->getId()
        );
    }
}
