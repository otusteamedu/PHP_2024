<?php

declare(strict_types=1);

namespace App\Domain\Exporter;

use App\Domain\News\News;

interface ExporterInterface
{
    public function exportNews(News $news): string;

    public static function GetConcreteExporter(string $fileExtension): static;
}