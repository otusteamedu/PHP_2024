<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\GenerateReport;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GenerateReportRequest
{
    public function __construct(
        #[Assert\All([
            new Assert\Type('integer'),
            new Assert\Positive,
        ])]
        public array $postIds = []
    ) {}
}
