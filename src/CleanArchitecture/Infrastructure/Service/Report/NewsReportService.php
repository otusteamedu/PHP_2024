<?php

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\Report;

use AlexanderGladkov\CleanArchitecture\Application\Service\Report\GenerateReportResult;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\GetReportFullFilenameParams;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\GetReportFullFilenameResult;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\NewsReportServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\ReportFileNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Dto\NewsDto;
use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;
use Slim\Views\Twig;
use Symfony\Component\Uid\Uuid;
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

    public function getReportFullFilename(GetReportFullFilenameParams $params): GetReportFullFilenameResult
    {
        $fullFilename = $this->reportsDirectory . '/' . $params->getFilename();
        if (!file_exists($fullFilename)) {
            throw new ReportFileNotFoundException();
        }

        return new GetReportFullFilenameResult($fullFilename);
    }

    /**
     * @param NewsDto[] $newsDtoList
     */
    public function generateReport(array $newsDtoList): GenerateReportResult
    {
        try {
            $html = $this->twig->getEnvironment()->render('/report/news.html.twig', ['news' => $newsDtoList]);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->createReportsDirectoryIfNotExists();
        $uuid = Uuid::v6()->toString();
        $filename = 'news_' . $uuid . '.html';
        $fullFilename = $this->reportsDirectory . '/' . $filename;
        file_put_contents($fullFilename, $html);
        return new GenerateReportResult($filename);
    }

    private function createReportsDirectoryIfNotExists(): void
    {
        if (!file_exists($this->reportsDirectory)) {
            mkdir($this->reportsDirectory, 0777, true);
        }
    }
}
