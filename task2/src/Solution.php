<?php

declare(strict_types=1);

namespace App;

class Solution
{
    /**
     * @param string $digits
     * @return array
     */
    public function letterCombinations(string $digits): array
    {
        $num_letters = [
            "2" => ["a", "b", "c"],
            "3" => ["d", "e", "f"],
            "4" => ["g", "h", "i"],
            "5" => ["j", "k", "l"],
            "6" => ["m", "n", "o"],
            "7" => ["p", "q", "r", "s"],
            "8" => ["t", "u", "v"],
            "9" => ["w", "x", "y", "z"],
        ];
        $result = [""];
        if ($digits == "") {
            return [];
        }

        for ($i = 0; $i < strlen($digits); $i++) {
            $combinations = [];
            foreach ($result as $letter) {
                foreach ($num_letters[$digits[$i]] as $value) {
                    $combinations[] = $letter . $value;
                }
                $result = $combinations;
            }
        }
        return $result;
    }
}
