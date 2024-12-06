<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Crawler\Dto\NewsItemCrawlerRequestDto;
use App\Application\Crawler\NewsItemCrawlerInterface;
use App\Application\UseCase\Dto\SubmitNewsItemRequestDto;
use App\Application\UseCase\Dto\SubmitNewsItemResponseDto;
use App\Domain\Factory\NewsItemFactoryInterface;
use App\Domain\Repository\NewsItemRepositoryInterface;

class AddNewsItemUseCase
{
    public function __construct(
        private readonly NewsItemFactoryInterface $newsItemFactory,
        private readonly NewsItemRepositoryInterface $newsItemRepository,
        private readonly NewsItemCrawlerInterface $newsItemCrawler,
    ) {
    }

    public function __invoke(SubmitNewsItemRequestDto $requestDto): SubmitNewsItemResponseDto
    {
        $newsItemCrawlerRequestDto = new NewsItemCrawlerRequestDto($requestDto->url);
        $newsItemCrawlerResponseDto = $this->newsItemCrawler->getNewsItemByUrl($newsItemCrawlerRequestDto);

        $newsItem = $this->newsItemFactory->create(
            $newsItemCrawlerResponseDto->title,
            $newsItemCrawlerResponseDto->url,
            $newsItemCrawlerResponseDto->date,
        );

        $this->newsItemRepository->save($newsItem);

        return new SubmitNewsItemResponseDto(
            $newsItem->getId()
        );
    }
}
