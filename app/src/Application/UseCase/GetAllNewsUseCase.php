<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Dto\SubmitNewsItemForListResponseDto;
use App\Domain\Repository\NewsItemRepositoryInterface;

class GetAllNewsUseCase
{
    public function __construct(
        private readonly NewsItemRepositoryInterface $repository,
    ) {
    }

    public function __invoke(): array
    {
        $newsList = $this->repository->findAll();
        foreach ($newsList as $item) {
            $arNews[] = new SubmitNewsItemForListResponseDto(
                $item->getId(),
                $item->getTitle()->getValue(),
                $item->getUrl()->getValue(),
                $item->getDate()->getValue()
            );
        }

        return $arNews ?? [];
    }
}
