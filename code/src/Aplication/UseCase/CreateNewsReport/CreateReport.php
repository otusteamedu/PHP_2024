<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\UseCase\CreateNewsReport;

use Asyrovatkin\Hw14\Domain\Repository\NewsRepositoryInterface;

class CreateReport
{
    const SITE_URL = 'http://mysite.local/';
    const ROOT_PATH = __DIR__ . '/../../../../';
    const REPORT_FOLDER = 'reports/';
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository
    )
    {
    }

    public function process($ids): string
    {
        $newsList = $this->newsRepository->findByIds($ids);
        $content = (new ReportBuilder($newsList))->build();
        return $this->saveReport($content);
    }

    private function saveReport($content): string
    {
        $fileName = uniqid('report_') . '.html';
        file_put_contents(self::ROOT_PATH . self::REPORT_FOLDER . $fileName, $content);
        return self::SITE_URL . self::REPORT_FOLDER . $fileName;
    }
}