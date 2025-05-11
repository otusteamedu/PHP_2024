<?php

namespace Anatolyshilyaev\Hw14\Application\ReportGenerator;

class ReportGeneratorResponse
{
    /**
     * @param string $filename
     */
    public function __construct(
        public readonly string $filename,
    ) {
        // Empty constructor
    }
}
