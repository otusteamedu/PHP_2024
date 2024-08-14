<?php

class Solution
{
    private  $map = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz',
        ];

    private $ans = [];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) 
    {
        if (empty($digits)) {
            return [];
        }

        $letters = $this->map[$digits[0]];
        for ($j=0; $j < strlen($letters); $j++) {
            $this->generate($letters[$j], 1, $digits);
        }

        return $this->ans;
    }

    private function generate($s, $i, $digits)
    {
        
        if ($i === strlen($digits)) {
            $this->ans[] = $s;
            return;
        }

        $letters = $this->map[$digits[$i]];
        for ($j=0; $j < strlen($letters); $j++) {
            $this->generate($s . $letters[$j], $i+1, $digits);
        }
    }
}
