<?php

declare(strict_types=1);

namespace App\Application\UseCase\Report;

class ReportResponse
{
    /**
     * @param News[] $news
     */
    public function __construct(
        public iterable $news
    ) {
    }
}
