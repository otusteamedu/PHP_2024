<?php

declare(strict_types=1);

namespace Lrazumov\Hw29;

class FractionRecurringDecimal
{
    /**
     * @param int $numerator
     * @param int $denominator
     * @return string
     */
    public function solution(
      int $numerator,
      int $denominator
    ): string
    {
        return (string) ($numerator / $denominator);
    }
}
