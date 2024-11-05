<?php

declare(strict_types=1);

namespace Irayu\Hw14\Domain\LetterCombination;

class JustSolution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public const MAPPING = [
        2 => 'abc',
        3 => 'def',
        4 => 'ghi',
        5 => 'jkl',
        6 => 'mno',
        7 => 'pqrs',
        8 => 'tuv',
        9 => 'wxyz',
    ];

    public function letterCombinations($digits): array
    {
        return $this->rec($digits);
    }

    public function rec($digits, $result = []): array
    {
        if (empty($digits)) {
            return $result;
        }
        $letters = self::MAPPING[$digits[0]];
        $other = $this->rec(substr($digits, 1), $result);
        if (empty($other)) {
            for ($i = 0; $i < strlen($letters); $i++) {
                $result[] = $letters[$i];
            }
        } else {
            for ($i = 0; $i < strlen($letters); $i++) {
                for ($j = 0; $j < count($other); $j++) {
                    $result[] = $letters[$i] . $other[$j];
                }
            }
        }

        return $result;
    }
}
