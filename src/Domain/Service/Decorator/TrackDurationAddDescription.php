<?php

declare(strict_types=1);

namespace App\Domain\Service\Decorator;

use App\Domain\ValueObject\IGetFormatedDuration;

class TrackDurationAddDescription implements IGetFormatedDuration
{
    public function __construct(
        private readonly IGetFormatedDuration $trackDuration
    ) {
    }

    public function getFormatedDuration(): string
    {
        return 'Время исполнения: ' . $this->trackDuration->getFormatedDuration();
    }
}
