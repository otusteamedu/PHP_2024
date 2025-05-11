<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews;

/**
 * @param string $filename
 */
class GetReportNewsResponse
{
    public function __construct(
        public readonly string $filename,
    ) {
        // Empty constructor
    }
}
