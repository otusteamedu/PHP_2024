<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetNewsReportRequest
{
    #[Assert\Count(min: 1)]
    public array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }
}
