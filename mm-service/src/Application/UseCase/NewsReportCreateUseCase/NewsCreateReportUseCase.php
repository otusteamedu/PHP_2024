<?php
declare(strict_types=1);

namespace App\Application\UseCase\NewsReportCreateUseCase;

use App\Application\Report\ReportGeneratorInterface;
use App\Application\UseCase\NewsReportCreateUseCase\Boundary\NewsCreateReportRequest;
use App\Domain\Repository\NewsRepositoryInterface;

final class NewsCreateReportUseCase
{
    public function __construct(
        private NewsRepositoryInterface  $newsRepository,
        private ReportGeneratorInterface $reportGenerator,
    )
    {
    }

    public function __invoke(NewsCreateReportRequest $request): string
    {
        $news = $this->newsRepository->findByIds($request->getIds());

        return $this->reportGenerator->generate(
            $news,
            ReportGeneratorInterface::FORMAT_HTML,
            ['template' => $request->getTemplate()]
        );
    }
}
