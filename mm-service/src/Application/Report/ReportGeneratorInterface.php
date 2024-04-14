<?php
declare(strict_types=1);

namespace App\Application\Report;

use App\Application\Report\Exception\UnsupportedReportException;

interface ReportGeneratorInterface
{
    const FORMAT_HTML = 'html';

    /**
     * @param mixed $data
     * @param string $format
     * @param array $context
     * @return string
     *
     * @throws UnsupportedReportException
     */
    public function generate(mixed $data, string $format, array $context = []): string;
}
