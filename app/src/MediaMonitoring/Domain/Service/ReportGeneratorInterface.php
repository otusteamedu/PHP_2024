<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Domain\Service;

use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Enum\ReportType;

interface ReportGeneratorInterface
{
    public function getType(): ReportType;

    public function generate(Post ...$posts): string;
}
