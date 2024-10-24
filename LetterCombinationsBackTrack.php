<?php

class LetterCombinations 
{
    /**
    * @param String $digits
    * @return String[]
    */
    public function getLetterCombination($digits) 
    {
        if ($digits === '') {
            return [];
        }

        $btnArray =  [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];

        $result  = [];
        $current = '';

        $this->getCombinations(0, $digits, $btnArray, $current, $result);
        
        return $result;
    }

    private function getCombinations($start, $nums, $btnArray, &$current, &$result) 
    {
        if (strlen($current) === strlen($nums)) {
            $result[] = $current;

            return;
        }

        for ($i = $start; $i < strlen($nums); $i++) {
            $n = intval($nums[$i]);

            for ($j = 0; $j < count($btnArray[$n]); $j++) {
                $ch = $btnArray[$n][$j];
                $current .= $ch;
                $this->getCombinations($i + 1, $nums, $btnArray, $current, $result);
                $current = substr($current, 0, -1);
            }
        }
    }
}