<?php

declare(strict_types=1);

namespace App\Application\Helper;

use App\Domain\Entity\News;

interface ReportGeneratorInterface
{
    /**
     * @param list<News> $newsList
     * @return string
     */
    public function generate(array $newsList): string;
}
