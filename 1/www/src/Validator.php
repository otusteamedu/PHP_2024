<?php

namespace Ahar\Hw4;

use Ahar\Hw4\exceptions\ValidateExceptions;

class Validator
{
    public function validate(string $value): void
    {
        if (empty($value)) {
            throw new ValidateExceptions('Строка пустая');
        }

        if (!preg_match('/^[()]+$/', $value)) {
            throw new ValidateExceptions("Только '(' и ')'");
        }

        $open = 0;
        foreach (str_split($value) as $char) {
            if ($char === "(") {
                $open++;
            } elseif ($char === ")") {
                $open--;
            }

            if ($open < 0) {
                throw new ValidateExceptions("Ошибка числа )(");
            }
        }

        if ($open !== 0) {
            throw new ValidateExceptions("Ошибка числа )(");
        }
    }
}
