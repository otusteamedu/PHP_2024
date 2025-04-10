<?php

declare(strict_types=1);

namespace Valen\App\Application\News\UseCase\GetNews;

use Valen\App\Domain\News\Repository\NewsRepositoryInterface;

class GetNewsUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function execute(): array
    {
        $result = [];
        $news = $this->newsRepository->findAll();

        foreach ($news as $item) {
            // TODO createDTO
        }

        return $result;
    }
}
