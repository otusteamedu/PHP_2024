<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DateTimeImmutable;

class Date
{
    private DateTimeImmutable $date;

    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}