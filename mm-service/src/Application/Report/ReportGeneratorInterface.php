<?php

declare(strict_types=1);

namespace App\Application\Report;

use App\Application\Report\Exception\UnsupportedReportException;

interface ReportGeneratorInterface
{
    public const FORMAT_HTML = 'html';

    /**
     * @param mixed[] $context
     *
     * @throws UnsupportedReportException
     */
    public function generate(mixed $data, string $format, array $context = []): string;
}
