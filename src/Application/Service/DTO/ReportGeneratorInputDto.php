<?php

declare(strict_types=1);

namespace App\Application\Service\DTO;

readonly class ReportGeneratorInputDto
{
    /**
     * @param ReportNewsDto[] $newsList
     */
    public function __construct(
        public array $newsList,
    ) {
    }
}
