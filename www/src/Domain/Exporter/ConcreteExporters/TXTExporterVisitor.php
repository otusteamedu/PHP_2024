<?php

declare(strict_types=1);

namespace App\Domain\Exporter\ConcreteExporters;

use App\Domain\Exporter\VisitorInterface;
use App\Domain\News\News;

class TXTExporterVisitor implements VisitorInterface
{

    public function visitNews(News $news)
    {
        // TODO: Implement visitNews() method.
    }
}