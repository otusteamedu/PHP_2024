<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Infrastructure\Report\Exception\FormatterNotFoundException;

interface ReportFormatterProviderInterface
{
    /**
     * @throws FormatterNotFoundException
     */
    public function getByFormatDefinition(string $format): ReportFormatter;
}
