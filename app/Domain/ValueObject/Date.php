<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Contract\ValueObjectInterface;
use Carbon\Carbon;

class Date implements ValueObjectInterface
{
    protected string $date;

    public function __construct(string $value)
    {
        $this->date = $this->dateParse($value);
    }

    public function getValue(): string
    {
        return $this->date;
    }

    public function __toString(): string
    {
        return $this->date;
    }

    private function dateParse(string $value): string
    {
        return Carbon::parse($value)->toDateString();
    }
}
