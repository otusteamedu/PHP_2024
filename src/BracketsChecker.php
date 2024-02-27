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

        $balanceOpen = 0;
        $balanceClose = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] == '(') {
                $balanceOpen++;
            }
            if ($string[$i] == ')') {
                $balanceClose++;
            }
        }

        if ($balanceOpen !== $balanceClose) {
            // Если счётчик стал отрицательным, значит есть закрытая скобка без соответствующей открытой
            throw new InvalidBracketsException();
        }
    }
}
