<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use Carbon\CarbonImmutable;

class DateTime extends CarbonImmutable
{
    public function __toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }
}