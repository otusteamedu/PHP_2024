<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Application\Report\Exception\UnsupportedReportException;

abstract class ReportFormatter
{
    /**
     * @param mixed[] $context
     *
     * @throws UnsupportedReportException
     */
    abstract public function checkSupports(mixed $data, array $context = []): void;

    /**
     * @param mixed[] $context
     *
     * @throws UnsupportedReportException
     */
    public function format(mixed $data, array $context = []): mixed
    {
        $this->checkSupports($data, $context);

        return $this->process($data, $context);
    }

    /**
     * @param mixed[] $context
     */
    abstract protected function process(mixed $data, array $context = []): mixed;

    abstract public static function getFormatDefinition(): string;
}
