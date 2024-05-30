<?php

declare(strict_types=1);

namespace App\Application\Service\DTO;

use App\Domain\Entity\News;

readonly class ReportGeneratorInputDto
{
    /**
     * @param News[] $newsList
     */
    public function __construct(
        public array $newsList,
    ) {
    }
}
