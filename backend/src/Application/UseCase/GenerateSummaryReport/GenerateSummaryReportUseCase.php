<?php

declare(strict_types=1);

namespace App\Application\UseCase\GenerateSummaryReport;

use App\Domain\Repository\NewsRepositoryInterface;

class GenerateSummaryReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
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
        $fileName = 'report_' . uniqid('', true) . '.html';
        $filePath = __DIR__ . '/../../../public/reports/' . $fileName;

        if (!is_dir(dirname($filePath))) {
            if (!mkdir($concurrentDirectory = dirname($filePath), 0777, true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }

        file_put_contents($filePath, $htmlContent);

        return new GenerateSummaryReportResponse('/reports/' . $fileName);
    }
}
