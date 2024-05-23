<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\CreateReport;

final readonly class CreateReportResponse
{
    public function __construct(
        public string $link
    ) {
    }
}
