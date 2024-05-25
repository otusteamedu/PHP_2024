<?php

declare(strict_types=1);

namespace App\Infrastructure\Exporter;

use App\Domain\News\News;

class TXTExporter extends BaseExporter
{
    public function exportNews(News $news): string
    {
        return <<<TXT
Title: {$news->getTitle()}
Body: {$news->getBody()}
Author: {$news->getAuthor()->getUsername()}
TXT;

    }
}