<?php

declare(strict_types=1);

namespace App\Application;

interface StaticFileStorageInterface
{
    public function saveReportFile(string $fileName, string $content): void;
    public function getReportFilesDir(): string;
    public function getStaticReportFileUriPath(string $fileName): string;
}