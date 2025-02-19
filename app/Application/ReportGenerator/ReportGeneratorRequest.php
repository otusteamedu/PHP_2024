<?php

namespace App\Application\ReportGenerator;

class ReportGeneratorRequest
{
    /**
     * @param NewsDTO[] $newsDto
     */
    public function __construct(
        public readonly array $newsDto,
    ) {
    }
}
