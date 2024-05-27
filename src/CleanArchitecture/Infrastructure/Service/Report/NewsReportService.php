<?php

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\Report;

use AlexanderGladkov\CleanArchitecture\Application\Service\Report\NewsReportServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\ReportFileNotFoundException;
use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use RuntimeException;

class NewsReportService implements NewsReportServiceInterface
{
    public function __construct(
        private Twig $twig,
        private string $reportsDirectory
    ) {
    }

    public function getReportFullFilename($filename): string
    {
        $fullFilename = $this->reportsDirectory . '/' . $filename;
        if (!file_exists($fullFilename)) {
            throw new ReportFileNotFoundException();
        }

        return $fullFilename;
    }

    /**
     * @param News[] $news
     * @return string
     */
    public function generateReport(array $news): string
    {
        try {
            $html = $this->twig->getEnvironment()->render('/report/news.html.twig', ['news' => $news]);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->createReportsDirectoryIfNotExists();
        $filename = 'news.html';
        $fullFilename = $this->reportsDirectory . '/' . $filename;
        file_put_contents($fullFilename, $html);
        return $filename;
    }

    private function createReportsDirectoryIfNotExists(): void
    {
        if (!file_exists($this->reportsDirectory)) {
            mkdir($this->reportsDirectory, 0777, true);
        }
    }
}
