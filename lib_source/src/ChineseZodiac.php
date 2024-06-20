<?php

declare(strict_types=1);

namespace Tbublikova\OtusChZodiac;

class ChineseZodiac
{
    private static array $zodiacSigns = [
        'Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 'Snake',
        'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig'
    ];

    public function getZodiac(int $year): string
    {
        if ($year < 0) {
            throw new \InvalidArgumentException("Year must be a positive integer.");
        }
        if ($year > 3000) {
            throw new \InvalidArgumentException("Year must be an integer between 1 and 3000.");
        }

        $baseYear = 1924;
        $index = ($year - $baseYear) % 12;
        return self::$zodiacSigns[$index < 0 ? $index + 12 : $index];
    }
}
