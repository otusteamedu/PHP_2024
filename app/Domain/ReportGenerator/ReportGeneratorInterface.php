<?php

namespace Domain\ReportGenerator;

use Domain\Entity\News;

interface ReportGeneratorInterface
{

    /**
     * @param News[] $news
     * @return ReportGeneratorResponse
     */
    public function generate(array $news): ReportGeneratorResponse;
}
