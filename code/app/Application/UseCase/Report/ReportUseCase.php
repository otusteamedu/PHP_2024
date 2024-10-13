<?php

declare(strict_types=1);

namespace App\Application\UseCase\Report;

use App\Application\Report\GeneratorInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class ReportUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
        private GeneratorInterface $reportGenetorator
    ) {
    }

    public function __invoke(ReportRequest $request): ReportResponse
    {

        $news  = [];

        foreach ($request->ids as $id) {
            $item = $this->newsRepository->getById($id);
            if (!is_null($item)) {
                $news[] = $item;
            }
        }

        $reportUrl = $this->reportGenetorator->generate($news);

        return new ReportResponse($reportUrl);
    }
}
