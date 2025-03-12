<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Infrastructure\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ReportGenerator
{
    private string $reportsDirectory;

    public function __construct(string $reportsDirectory)
    {
        $this->reportsDirectory = $reportsDirectory;
    }

    public function generate(array $newsList): string
    {
        if (!is_dir($this->reportsDirectory)) {
            mkdir($this->reportsDirectory, 0777, true);
        }

        $reportPath = $this->reportsDirectory . '/report_' . uniqid() . '.html';

        $htmlContent = '<ul>' . PHP_EOL;
        foreach ($newsList as $news) {
            $htmlContent .= '<li><a href="' . htmlspecialchars($news->getUrl()->getValue()) . '">' . htmlspecialchars($news->getTitle()->getValue()) . '</a></li>' . PHP_EOL;
        }
        $htmlContent .= '</ul>' . PHP_EOL;

        try {
            file_put_contents($reportPath, $htmlContent);
        } catch (FileException $e) {
            throw new FileException('Failed to generate report file.');
        }

        return $reportPath;
    }
}
