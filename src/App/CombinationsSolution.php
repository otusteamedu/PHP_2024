<?php

namespace VSukhov\Hw13\App;

class CombinationsSolution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if (empty($digits)) return [];

        $map = [
            '2' => 'abc', '3' => 'def', '4' => 'ghi',
            '5' => 'jkl', '6' => 'mno', '7' => 'pqrs',
            '8' => 'tuv', '9' => 'wxyz'
        ];

        $result = [""];

        foreach (str_split($digits) as $digit) {
            $newResult = [];
            foreach ($result as $combination) {
                foreach (str_split($map[$digit]) as $letter) {
                    $newResult[] = $combination . $letter;
                }
            }
            $result = $newResult;
        }

        return $result;
    }
}
