<?php

namespace App\Domain\Services;

interface ReportGeneratorInterface
{
    public function generateHtml(iterable $newsEntities): string;
}
