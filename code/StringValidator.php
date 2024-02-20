<?php
declare(strict_types=1);

namespace Hukimato\Code;

class StringValidator
{
    public static function validateString(string $string): bool
    {
        $parenthesesCounter = 0;

        foreach (str_split($string) as $char) {
            if ($char === '(') {
                $parenthesesCounter++;
                continue;
            }
            if ($char === ')') {
                $parenthesesCounter--;
                // Проверить можно curl -X POST http://mysite.local/ -d "string=())"
                if ($parenthesesCounter < 0) {
                    break;
                }
                continue;
            }
            return false;
        }

        // Проверить можно curl -iX POST http://mysite.local/ -d "string=()("
        return $parenthesesCounter === 0;
    }
}
