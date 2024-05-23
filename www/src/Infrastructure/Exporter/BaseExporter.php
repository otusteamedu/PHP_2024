<?php

declare(strict_types=1);

namespace App\Infrastructure\Exporter;

use App\Domain\Exporter\ExporterInterface;
use App\Domain\News\News;

class BaseExporter implements ExporterInterface
{

    public function exportNews(News $news): string
    {
        throw new \Exception("Base Exporter does not support exportNews");
    }

    public static function GetConcreteExporter(string $fileExtension): static
    {
        switch ($fileExtension) {
            case 'pdf':
                return new PDFExporter();
            case 'txt':
                return new TXTExporter();
            case 'html':
                return new HTMLExporter();
            default:
                throw new \Exception('Unsupported file extension');
        }
    }
}