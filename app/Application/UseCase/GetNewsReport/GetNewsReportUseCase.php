<?php

namespace App\Application\UseCase\GetNewsReport;

use App\Application\ReportGenerator\NewsDTO;
use App\Application\ReportGenerator\ReportGeneratorInterface;
use App\Application\ReportGenerator\ReportGeneratorRequest;
use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $reportGenerator,
    ) {
    }

    public function __invoke(GetNewsReportRequest $request): GetNewsReportResponse
    {
        // Получить список новостей из базы
        $newsList = $this->newsRepository->findByIds($request->ids);

        // Переложить список в массив DTO
        $newsDtoArr = [];
        foreach ($newsList as $news) {
            $newsDtoArr[] = new NewsDTO(
                $news->getTitle()->getValue(),
                $news->getUrl()->getValue(),
            );
        }

        // Сформировать отчет и получить ссылку на него
        $reportGeneratorResponse = $this->reportGenerator->generate(new ReportGeneratorRequest($newsDtoArr));

        // Сформировать и вернуть ответ
        return new GetNewsReportResponse($reportGeneratorResponse->link);
    }
}
