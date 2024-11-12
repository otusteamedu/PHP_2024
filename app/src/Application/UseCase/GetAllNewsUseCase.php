<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Dto\SubmitNewsListResponseDto;
use App\Domain\Repository\NewsItemRepositoryInterface;

class GetAllNewsUseCase
{
    public function __construct(
        private readonly NewsItemRepositoryInterface $repository,
    ) {
    }

    public function __invoke(): SubmitNewsListResponseDto
    {
        $newsList = $this->repository->findAll();
        foreach ($newsList as $item) {
            $arNews[] = [
                'id' => $item->getId(),
                'title' => $item->getTitle()->getValue(),
                'url' => $item->getUrl()->getValue(),
                'date' => $item->getDate()->getValue(),
            ];
        }

        return new SubmitNewsListResponseDto($arNews ?? []);
    }
}
