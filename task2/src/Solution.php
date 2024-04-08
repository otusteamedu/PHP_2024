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
            2 => ["a", "b", "c"],
            3 => ["d", "e", "f"],
            4 => ["g", "h", "i"],
            5 => ["j", "k", "l"],
            6 => ["m", "n", "o"],
            7 => ["p", "q", "r", "s"],
            8 => ["t", "u", "v"],
            9 => ["w", "x", "y", "z"],
        ];
        $array_letters = [];
        $result = [];
        if ($digits == "") {
            return $result;
        }
        $digits_array = str_split($digits);

        foreach ($digits_array as $digit) {
            if (array_key_exists($digit, $num_letters)) {
                if (count($digits_array) == 1) {
                    return $num_letters[$digit];
                }
                $array_letters[] = $num_letters[$digit];
            }
        }

        $flag = true;
        $count = 0;
        while ($flag) {
            for ($i = 0; $i < count($array_letters); $i++) {
                for ($j = 0; $j < count($array_letters[$i]); $j++) {
                    if ($array_letters[$i][$j] == $array_letters[0][$j]) {
                        $result[] = $array_letters[0][$j] . $array_letters[1][$count];
                    }
                    if ($count == count($array_letters[1]) - 1) {
                        $flag = false;
                    }
                }
            }
            $count++;
        }
        asort($result);
        return $result;
    }
}
