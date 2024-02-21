<?php

declare(strict_types=1);

namespace AlexanderGladkov\App\Validation;

use Exception;
use LogicException;

class Validation
{
    /**
     * @param string $string
     * @return void
     * @throws Exception
     */
    public function validateBrackets(string $string): void
    {
        if ($string === '') {
            throw new Exception('Строка не должна быть пустой!');
        }

        $matchResult = preg_match('/^[\(\)]+$/', $string);
        if ($matchResult === 0) {
            throw new Exception('Строка должна содержать только символы ( и )!');
        }

        $counter = 0;
        foreach (mb_str_split($string) as $symbol) {
            if ($symbol === '(') {
                $counter++;
                continue;
            }

            if ($symbol === ')') {
                $counter--;
                if ($counter < 0) {
                    throw new Exception('Строка не корректна!');
                }

                continue;
            }

            throw new LogicException();
        }

        if ($counter !== 0) {
            throw new Exception('Строка не корректна!');
        }
    }
}
