<?php

namespace App\Application\Actions;

use App\Application\Responses\ExportNewsResponse;
use App\Domain\Services\FileStorageServiceInterface;
use App\Domain\Services\ReportGeneratorInterface;

class ExportNewsAction
{
    public function __construct(
        private readonly ReportGeneratorInterface $reportGenerator,
        private readonly FileStorageServiceInterface $fileStorageService
    ) {
    }

    public function __invoke(iterable $newsEntities): ExportNewsResponse
    {
        $html = $this->reportGenerator->generateHtml($newsEntities);

        $fileName = 'news_report_' . time() . '.html';
        $filePath = 'exports/' . $fileName;

        $url = $this->fileStorageService->store($filePath, $html);

        return new ExportNewsResponse($url);
    }
}
