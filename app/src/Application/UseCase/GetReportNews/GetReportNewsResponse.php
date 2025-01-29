<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews;

class GetReportNewsResponse
{

    public function __construct(
        public readonly string $link,
    ) {}
}
