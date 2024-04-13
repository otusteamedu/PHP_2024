<?php
declare(strict_types=1);

namespace App\Application\Report;

class ReportGenerator implements ReportGeneratorInterface
{
    public function generate(mixed $data, ReportFormatter $formatter, array $context = []): string
    {
        return $formatter->format($data, $context);
    }
}
