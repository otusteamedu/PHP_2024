<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\EmptyStringException;
use Alogachev\Homework\Exception\InvalidBracketsException;

class BracketsChecker
{
    public function check(?string $string): void
    {
        if (empty($string)) {
            throw new EmptyStringException();
        }

        $balance = 0; // Счётчик для отслеживания баланса скобок

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] == '(') {
                $balance++; // Увеличиваем счётчик для открытой скобки
            } elseif ($string[$i] == ')') {
                $balance--; // Уменьшаем счётчик для закрытой скобки
            }

            if ($balance < 0) {
                // Если счётчик стал отрицательным, значит есть закрытая скобка без соответствующей открытой
                throw new InvalidBracketsException();
            }
        }
    }
}
