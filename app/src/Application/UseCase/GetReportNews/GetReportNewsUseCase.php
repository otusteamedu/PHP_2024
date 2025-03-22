<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews;

use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorInterface;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorRequest;
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
        $newsEntities = $this->newsRepository->findByIds($request);

        //
        $reportGeneratorRequests = [];
        foreach ($newsEntities as $newEntity) {
            $reportGeneratorRequests[] = new ReportGeneratorRequest(
                $newEntity->getTitle()->getValue(),
                $newEntity->getUrl()->getValue()
            );
        }
        //Generate report
        $reportFileName = $this->reportGenerator->generate($reportGeneratorRequests);

        return new GetReportNewsResponse($reportFileName->filename);
    }
}
