<?php

namespace Application\UseCase\GetNewsReport;

use Domain\ReportGenerator\ReportGeneratorInterface;
use Domain\Repository\NewsRepositoryInterface;

class GetNewsReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $reportGenerator,
    )
    {
    }

    public function __invoke(GetNewsReportRequest $request): GetNewsReportResponse
    {
        // Получить список новостей из базы
        $newsList = $this->newsRepository->findByIds($request->ids);

        // Сформировать отчет и получить ссылку на него
        $reportGeneratorResponse = $this->reportGenerator->generate($newsList);

        // Сформировать и вернуть ответ
        return new GetNewsReportResponse($reportGeneratorResponse->link);
    }

}
