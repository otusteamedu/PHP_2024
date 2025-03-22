<?php

namespace Anatolyshilyaev\Hw14\Application\ReportGenerator;

class ReportGeneratorRequest
{

    /**
     * @param string $title
     * @param string $url
     */
    public function __construct(
        public readonly string $title,
        public readonly string $url
    ) {
        // Empty constructor
    }
}
