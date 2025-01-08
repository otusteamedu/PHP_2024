<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw4;

use Exception;

class StringValidator
{
    public static function validateBrackets(string $string): void
    {
        if (!empty($string)) {
            $openedBracketsCount = 0;
            for ($i = 0, $n = strlen($string); $i < $n; $i++) {
                if ($string[$i] == '(') {
                    $openedBracketsCount++;
                } else if ($string[$i] == ')') {
                    $openedBracketsCount--;
                }

                if ($openedBracketsCount < 0) {
                    break;
                }
            }

            if ($openedBracketsCount !== 0) {
                throw new Exception('Все плохо', 400);
            }
        }
    }
}
