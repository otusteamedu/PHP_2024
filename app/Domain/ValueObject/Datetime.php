<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DateTimeImmutable;
use Exception;

class Datetime
{
    protected DateTimeImmutable $date;

    /**
     * @throws Exception
     */
    public function __construct(string $value)
    {
        $this->date = $this->dateParse($value);
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->date;
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d H:m');
    }

    /**
     * @throws Exception
     */
    private function dateParse(string $value): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y-m-d H:m',$value);
    }
}
