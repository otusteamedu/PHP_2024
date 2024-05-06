<?php

declare(strict_types=1);

namespace App\Infrastructure\StaticFileStorage;

use App\Domain\Exception\DomainException;

class LocalStaticFileStorage implements StaticFileStorageInterface
{
    public function saveReportFile(string $content): string
    {
        if (!file_exists($this->getReportFilesDir())) {
            mkdir($this->getReportFilesDir(), 0777, true);
        }
        $fileName = 'report_' . uniqid() . '.html';
        if (false === file_put_contents($this->getReportFilesDir() . '/' . $fileName, $content)) {
            throw new DomainException('Cannot save report file');
        }

        return '/files/reports/' . $fileName;
    }

    public function getReportFilesDir(): string
    {
        return getenv('STATIC_FILES_DIR') . '/reports';
    }
}