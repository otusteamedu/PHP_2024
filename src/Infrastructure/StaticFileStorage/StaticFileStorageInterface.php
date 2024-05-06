<?php

declare(strict_types=1);

namespace App\Infrastructure\StaticFileStorage;

interface StaticFileStorageInterface
{
    /**
     * @param string $content
     * @return string Путь до файла
     */
    public function saveReportFile(string $content): string;
    public function getReportFilesDir(): string;
}