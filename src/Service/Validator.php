<?php

namespace Ali\Service;

class Validator
{

    public function isValidString($str): bool
    {
        $stack = [];
        foreach (str_split($str) as $char) {
            if ($char === '(') {
                array_push($stack, $char);
            } elseif ($char === ')') {
                if (empty($stack)) {
                    return false;
                }
                array_pop($stack);
            }
        }

        return empty($stack);
    }

}