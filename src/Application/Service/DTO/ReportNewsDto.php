<?php

declare(strict_types=1);

namespace App\Application\Service\DTO;

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

readonly class ReportNewsDto
{
    public function __construct(
        public Title $title,
        public Url $url,
    ) {
    }
}
