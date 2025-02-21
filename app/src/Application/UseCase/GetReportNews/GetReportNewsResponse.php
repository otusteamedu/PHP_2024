<?php

namespace AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews;

class GetReportNewsResponse
{
    public function __construct(
        public readonly string $link,
    ) {
        // Empty constructor
    }
}
