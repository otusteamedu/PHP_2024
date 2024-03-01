<?php

namespace StringAnalyzer;
class StringAnalyzer
{
    public function checkBrackets(string $string): bool
    {
        $balance = 0;
        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            if ($string[$i] === '(') {
                $balance++;
            } elseif ($string[$i] === ')') {
                $balance--;
                if ($balance < 0) {
                    return false;
                }
            }
        }
        return $balance === 0;
    }
}