<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\EmptyStringException;

class BracketsChecker
{
    public function check(?string $string): void
    {
        if (empty($string)) {
            throw new EmptyStringException();
        }

        echo 'Строка ' . $string . ' валидна<br>';
    }
}
