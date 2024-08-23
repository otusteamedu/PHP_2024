<?php

declare(strict_types=1);

namespace App\Application\UseCase\Report;

use App\Domain\Repository\NewsRepositoryInterface;

class ReportUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository
    ) {}

    public function __invoke(ReportRequest $request): ReportResponse
    {

        $news  = [];

        foreach ($request->ids as $id) {
            $item = $this->newsRepository->getById($id);
            if (!is_null($item)) {
                $news[] = $item;
            }
        }

        return new ReportResponse($news);
    }
}
