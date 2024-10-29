<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Repository;

use Irayu\Hw15\Domain;
use Irayu\Hw15\Domain\Entity\Report;

class FileReportRepository implements Domain\Repository\ReportRepositoryInterface
{
    private string $dirName;

    public function __construct(string $repoDirName)
    {
        $this->dirName = $repoDirName;
        if (!is_dir($this->dirName)) {
            mkdir($this->dirName, 0777, true);
        }
    }

    public function save(Report $report): void
    {
        $filePath = $this->createFile($report->getHash());

        $content = '<ul>' . PHP_EOL . "\t" . implode(
            PHP_EOL . "\t",
            array_map(
                fn(Domain\Entity\NewsItem $newsItem) =>
                   '<li id="' . (int)$newsItem->getId() . '">'
                    . '<a href="' . htmlspecialchars($newsItem->getUrl()->getValue()) . '">'
                    . $newsItem->getTitle()->getValue()
                    . '</a></li>' . PHP_EOL,
                $report->getNewsItems()
            )
        ) . PHP_EOL . '</ul>'
        ;

        file_put_contents($filePath, $content);
    }

    private function createFile(string $hashFileName): string
    {
        $filename = $this->dirName . '/' . $hashFileName . '.report';
        if (!file_exists($filename)) {
            $f = fopen($filename, 'w');
            fclose($f);
        }

        return $filename;
    }

    public function findByHash(string $hash): ?Domain\Entity\Report
    {
        return null;
    }

    public function findFileByHash(string $hash): ?string
    {
        if (file_exists($this->dirName . '/' . $hash . '.report')) {
            return file_get_contents($this->dirName . '/' . $hash . '.report');
        }

        return null;
    }
}
