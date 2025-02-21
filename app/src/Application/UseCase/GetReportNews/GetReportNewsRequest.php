<?php

namespace AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews;

/**
 * @param int[] $ids
 */

class GetReportNewsRequest
{
    public function __construct(
        public readonly array $ids,
    ) {
        // Empty constructor
    }
}
