<?php
declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Application\Report\Exception\UnsupportedReportException;

abstract class ReportFormatter
{
    /**
     * @param mixed $data
     * @param mixed[] $context
     * @return void
     *
     * @throws UnsupportedReportException
     */
    abstract public function checkSupports(mixed $data, array $context = []): void;

    /**
     * @param mixed $data
     * @param mixed[] $context
     * @return mixed
     *
     * @throws UnsupportedReportException
     */
    public function format(mixed $data, array $context = []): mixed
    {
        $this->checkSupports($data, $context);

        return $this->process($data, $context);
    }

    /**
     * @param mixed $data
     * @param mixed[] $context
     * @return mixed
     */
    abstract protected function process(mixed $data, array $context = []): mixed;
    abstract public static function getFormatDefinition(): string;
}
