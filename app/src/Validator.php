<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

use Exception;

class Validator
{
    /**
     * @return bool
     * @throws Exception
     */
    public static function validateRequest(): bool
    {
        if (empty($_POST['string']) || preg_match("/^\(.*\)/", $_POST['string'])) {
            throw new Exception('Некорректная строка', 400);
        }

        $counter = 0;
        $length = strlen($_POST['string']);

        for ($i = 0; $i < $length; $i++) {
            $bracket = $_POST['string'][$i];

            if ($bracket === '(') {
                $counter++;
            } elseif ($bracket === ')') {
                $counter--;
            }

            if ($counter < 0) {
                break;
            }
        }

        if ($counter !== 0) {
            throw new Exception('Строка не валидна', 400);
        }
        return true;
    }
}
