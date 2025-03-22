<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews;

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
