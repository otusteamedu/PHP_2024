<?php

namespace App\Domain\ReportGenerator;

use App\Domain\Entity\News;

interface ReportGeneratorInterface
{
    /**
     * @param News[] $news
     * @return ReportGeneratorResponse
     */
    public function generate(array $news): ReportGeneratorResponse;
}
