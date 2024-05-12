<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Response;

use Irayu\Hw15\Domain;

class GetReportNewsItemResponse implements DefaultNewsItemResponse
{
    public function __construct(
        public readonly ?Domain\Entity\Report $report,
        public readonly array $items,
    )
    {
    }
}
