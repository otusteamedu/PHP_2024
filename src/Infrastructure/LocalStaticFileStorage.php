<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\StaticFileStorageInterface;
use App\Domain\Exception\DomainException;

class LocalStaticFileStorage implements StaticFileStorageInterface
{
    public function saveReportFile(string $fileName, string $content): void
    {
        if (!file_exists($this->getReportFilesDir())) {
            mkdir($this->getReportFilesDir(), 0777, true);
        }
        $fileName = 'report_' . time() . '.html';
        if (false === file_put_contents($this->getReportFilesDir() . '/' . $fileName, $content)) {
            throw new DomainException('Cannot save report file');
        }
    }

    public function getReportFilesDir(): string
    {
        return getenv('STATIC_FILES_DIR') . '/reports';
    }

    public function getStaticReportFileUriPath(string $fileName): string
    {
        return '/files/reports/' . $fileName;
    }
}