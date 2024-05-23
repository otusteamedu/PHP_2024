<?php

declare(strict_types=1);

namespace App\Domain\Exporter;

interface ExportableInterface
{
    public function accept(ExporterInterface $exporter): string;
}