<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Infrastructure\Report\Exception\FormatterNotFoundException;

class ReportFormatterProvider implements ReportFormatterProviderInterface
{
    private iterable $formatters;

    /**
     * @param iterable<string, ReportFormatter> $formatters
     */
    public function __construct(iterable $formatters)
    {
        $this->formatters = $formatters instanceof \Traversable ? iterator_to_array($formatters) : $formatters;
    }

    /**
     * @throws FormatterNotFoundException
     */
    public function getByFormatDefinition(string $format): ReportFormatter
    {
        if (!isset($this->formatters[$format])) {
            throw new FormatterNotFoundException($format);
        }

        return $this->formatters[$format];
    }
}
