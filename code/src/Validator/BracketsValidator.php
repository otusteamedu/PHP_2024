<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw4\Validator;

class BracketsValidator
{
    /**
     * Проверка строки на корректность скобок.
     *
     * @param string $str Строка для проверки.
     * @return bool Возвращает true, если скобки в строке расставлены корректно.
     */
    public static function isBracketsValid(string $str): bool
    {
        $stack = [];

        foreach (str_split($str) as $char) {
            if ($char == '(') {
                $stack[] = $char;
            } elseif ($char == ')') {
                if (empty($stack) || array_pop($stack) != '(') {
                    return false;
                }
            }
        }

        return empty($stack);
    }
}
