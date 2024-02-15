<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

use Exception;

class Validator
{
    /**
     * @param string $string
     * @return string
     * @throws Exception
     */
    public static function validate(string $string): string
    {
        if (empty($string) || preg_match("/^\(.*\)/", $string)) {
            throw new Exception('Некорректная строка');
        }

        $counter = 0;
        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $bracket = $string[$i];

            if ($bracket === '(') {
                $counter++;
            } elseif ($bracket === ')') {
                $counter--;
            }
        }

        if ($counter !== 0) {
            throw new Exception('Строка не валидна', 400);
        }

        return 'OK';
    }
}
