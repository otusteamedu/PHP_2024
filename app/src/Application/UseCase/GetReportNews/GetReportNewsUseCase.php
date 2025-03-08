<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews;

use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class GetReportNewsUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $reportGenerator,
    ) {
        // Empty constructor
    }

    public function __invoke(GetReportNewsRequest $request): GetReportNewsResponse
    {
        //Get news
        $news = $this->newsRepository->findSome($request);

        //Generate report
        $reportFileName = $this->reportGenerator->generate($news);

        return new GetReportNewsResponse($reportFileName);
    }
}
