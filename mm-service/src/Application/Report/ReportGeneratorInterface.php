<?php
declare(strict_types=1);

namespace App\Application\Report;

use App\Application\Report\Exception\UnsupportedReportException;

interface ReportGeneratorInterface
{
    /**
     * @param mixed $data
     * @param ReportFormatter $formatter
     * @param array $context
     * @return string
     *
     * @throws UnsupportedReportException
     */
    public function generate(mixed $data, ReportFormatter $formatter, array $context = []): string;
}
