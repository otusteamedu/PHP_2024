<?php

namespace Anatolyshilyaev\Hw14\Application\ReportGenerator;

interface ReportGeneratorInterface
{
    public function generate(array $news): ?string;
}
