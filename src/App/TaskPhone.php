<?php

namespace App;

class TaskPhone
{
    private $lettersByDigits = [];

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
    public function letterCombinations($digits): array
    {
        $arrLettersByDigits = $this->getArrLettersByDigits($digits);

        if (empty($arrLettersByDigits)) return $arrLettersByDigits;

        $letters = array_shift($arrLettersByDigits);
        $combinations = $letters;

        $letters = array_shift($arrLettersByDigits);
        while (!empty($letters)) {
            $upgradeCombinations = [];

            foreach ($combinations as $key => $combination) {
                foreach ($letters as $letter) {
                    $upgradeCombinations[] = $combination.$letter;
                }
            }

            $combinations = $upgradeCombinations;

            $letters = array_shift($arrLettersByDigits);
        }

        return $combinations;
    }

    private function isCorrectDigit($digit): bool
    {
        return is_numeric($digit) && ($digit >= 2 && $digit <= 9);
    }

    private function getArrLettersByDigits($digits)
    {
        $lettersByDigits = [];

        for ($i = 0; $i < strlen($digits); $i++) {
            if (!$this->isCorrectDigit($digits[$i])) return [];

            $lettersByDigits[] = str_split($this->lettersByDigits[(int)$digits[$i]]);
        }

        return $lettersByDigits;
    }
}