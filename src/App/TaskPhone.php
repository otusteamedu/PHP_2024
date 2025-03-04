<?php

namespace App;

class TaskPhone
{
    private $lettersByDigits;

    public function __construct()
    {
        $this->lettersByDigits = [
            1 => [],
            2 => 'abc',
            3 => 'def',
            4 => 'ghi',
            5 => 'jkl',
            6 => 'mno',
            7 => 'pqrs',
            8 => 'tuv',
            9 => 'wxyz',
        ];
    }

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations(string $digits): array
    {
        $arrLettersByDigits = $this->getArrLettersByDigits($digits);
        return $this->getCombinations($arrLettersByDigits);
    }

    /**
     * @param array $arrLettersByDigits
     * @param array $combinations
     * @return String[]
     */
    private function getCombinations($arrLettersByDigits, $combinations = []): array
    {
        if (empty($arrLettersByDigits)) return $combinations;

        $letters = array_shift($arrLettersByDigits);

        if (empty($combinations)) {
            $combinations = $letters;
            return $this->getCombinations($arrLettersByDigits, $combinations);
        }

        $newCombinations = [];

        foreach ($letters as $letter) {
            foreach ($combinations as $combination) {
                $newCombinations[] = $combination.$letter;
            }
        }

        $combinations = $newCombinations;

        return $this->getCombinations($arrLettersByDigits, $combinations);
    }

    /**
     * @param $digit
     * @return bool
     */
    private function isCorrectDigit($digit): bool
    {
        return is_numeric($digit) && ($digit >= 2 && $digit <= 9);
    }

    /**
     * @param $digits
     * @return String[]
     */
    private function getArrLettersByDigits($digits): array
    {
        $lettersByDigits = [];

        for ($i = 0; $i < strlen($digits); $i++) {
            if (!$this->isCorrectDigit($digits[$i])) return [];

            $lettersByDigits[] = str_split($this->lettersByDigits[(int)$digits[$i]]);
        }

        return $lettersByDigits;
    }
}