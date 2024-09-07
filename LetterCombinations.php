<?php

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        $buttons = [
            2 => 'abc',
            3 => 'def',
            4 => 'ghi',
            5 => 'jkl',
            6 => 'mno',
            7 => 'pqrs',
            8 => 'tuv',
            9 => 'wxyz',
        ];
        $digitsArray = str_split($digits);
        $result = [];
        foreach ($digitsArray as $digit) {
            $result = $this->generateSeq($result, $digit, $buttons);
        }
        return $result;
    }

    private function generateSeq(array $lettersArray, string $digit, array $buttons): array
    {
        $set = str_split($buttons[$digit]);
        $newar = [];
        if ($lettersArray === []) {
            $newar = $set;
        } else {
            foreach ($lettersArray as $val) {
                foreach ($set as $newval) {
                    $newar[] = $val . $newval;
                }
            }
        }
        return $newar;
    }
}
