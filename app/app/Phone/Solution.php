<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Phone;

final class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits): array
    {
        $n = strlen($digits);
        if ($n === 0) {
            return [];
        }

        $map = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz',
        ];

        $head = $list = new Button($map[$digits[0]]);

        for ($i = 1; $i < $n; $i++) {
            $list->next = new Button($map[$digits[$i]]);
            $list = $list->next;
        }

        return explode(',', $head->getCombinations());
    }
}
