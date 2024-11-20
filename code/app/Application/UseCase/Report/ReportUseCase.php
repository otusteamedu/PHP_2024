<?php

declare(strict_types=1);

namespace App\Application\UseCase\Report;

use App\Application\Report\GeneratorInterface;
use App\Application\Report\ReportItem;
use App\Application\Report\ReportItemCollection;
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

        $reportItemCollection  = new ReportItemCollection();

        foreach ($request->ids as $id) {
            $item = $this->newsRepository->getById($id);
            if (!is_null($item)) {
                $reportItemCollection->append(
                    new ReportItem(
                        $item->getUrl()->getValue(),
                        $item->getTitle()->getValue(),
                        $item->getExportDate()->getValue()
                    )
                );
            }
        }

        $reportUrl = $this->reportGenetorator->generate($reportItemCollection);

        return new ReportResponse($reportUrl);
    }
}
