<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DateTimeImmutable;

class ExportDate
{
    /**
     * @param DateTimeImmutable $value
     * @return void
     */
    public function __construct(
        private DateTimeImmutable $value
    ) {
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
