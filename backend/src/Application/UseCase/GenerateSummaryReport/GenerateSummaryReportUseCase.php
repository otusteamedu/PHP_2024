<?php

declare(strict_types=1);

namespace App\Application\UseCase\GenerateSummaryReport;

use App\Application\Gateway\FileStorageGatewayInterface;
use App\Application\Gateway\FileStorageGatewayRequest;
use App\Domain\Repository\NewsRepositoryInterface;

class GenerateSummaryReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly FileStorageGatewayInterface $fileStorageGateway,
    ) {
    }

    public function __invoke(GenerateSummaryReportRequest $request): GenerateSummaryReportResponse
    {
        $newsList = $this->newsRepository->findByIds($request->ids);

        $htmlContent = "<ul>\n";
        foreach ($newsList as $news) {
            $htmlContent .= sprintf(
                "<li><a href=\"%s\">%s</a></li>\n",
                htmlspecialchars($news->getUrl()->getValue()),
                htmlspecialchars($news->getTitle()->getValue())
            );
        }
        $htmlContent .= "</ul>";

        $fileRequest = new FileStorageGatewayRequest(
            __DIR__ . '/../../../public/reports/',
            'report_' . uniqid('', true) . '.html',
            $htmlContent
        );

        $fileResponse = $this->fileStorageGateway->saveFile($fileRequest);

        return new GenerateSummaryReportResponse('/reports/' . basename($fileResponse->filePath));
    }
}
