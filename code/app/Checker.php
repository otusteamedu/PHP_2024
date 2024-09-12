<?php

declare(strict_types=1);

namespace Afilippov\Hw4\app;

class Checker
{
    public function check(string $inputString): bool
    {
        $openCount = 0;
        for ($i = 0; $i < strlen($inputString); $i++) {
            if ($inputString[$i] == '(') {
                $openCount++;
            } elseif ($inputString[$i] == ')') {
                $openCount--;
            }
            if ($openCount < 0) {
                break;
            }
        }

        return $openCount === 0;
    }
}
