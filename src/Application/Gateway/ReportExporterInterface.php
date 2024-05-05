<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Application\UseCase\News\Converter\ReportConverterInterface;
use App\Application\Settings\SettingsInterface;

interface ReportExporterInterface
{
    public function export(
        string $report,
        ReportConverterInterface $converter,
        ?SettingsInterface $settings = null
    ): mixed;
}
