<?php

namespace SergeyShirykalov\OtusBracketsChecker;

class BracketsChecker
{
    /**
     * Проверяет расстановку скобок в строке на валидность
     * @param string $bracketString
     * @return bool
     */
    public static function isValid(string $bracketString): bool
    {
        $stack = [];
        foreach (str_split($bracketString) as $bracket) {
            if ($bracket === '(') {
                array_push($stack, $bracket);
            } elseif ($bracket === ')') {
                if (is_null(array_pop($stack))) {
                    return false;
                }
            }
        }

        return count($stack) === 0;
    }
}
