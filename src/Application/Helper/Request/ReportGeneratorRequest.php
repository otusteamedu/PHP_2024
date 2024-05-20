<?php

declare(strict_types=1);

namespace App\Application\Helper\Request;

class ReportGeneratorRequest
{
    public function __construct(
        public readonly array $titles
    ) {}
}
