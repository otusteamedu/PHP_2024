<?php

declare(strict_types=1);

namespace Valen\App\Application\News\UseCase\GetReport;

use Valen\App\Application\News\UseCase\SaveFile\SaveFileInterface;
use Valen\App\Domain\News\Repository\NewsRepositoryInterface;

class GetReportUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
        private SaveFileInterface $saveFile,
    ) {
    }

    public function execute(array $id): string
    {
        $news = [];

        foreach ($id as $item) {
            $news[] = $this->newsRepository->findById($item);
        }

        return $this->saveFile->execute($news);
    }
}
