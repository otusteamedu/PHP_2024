<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Application\Report\ReportGeneratorInterface;

class ReportGenerator implements ReportGeneratorInterface
{
    public function __construct(
        private ReportFormatterProviderInterface $reportFormatterProvider,
    ) {
    }

    public function generate(mixed $data, string $format, array $context = []): string
    {
        $formatter = $this->reportFormatterProvider->getByFormatDefinition($format);

        return $formatter->format($data, $context);
    }
}
