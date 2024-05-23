<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\CreateReport;

final readonly class CreateReportRequest
{
    public array $ids;

    public function __construct(string $id, string ...$ids)
    {
        $ids[] = $id;
        $this->ids = $ids;
    }
}
