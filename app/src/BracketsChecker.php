<?php

declare(strict_types=1);

namespace Lrazumov\Hw4;

class BracketsChecker
{
    private function balanceOk(string $string): bool
    {
        $balance = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            if (empty($balance) && $string[$i] === ')') {
                return false;
            } elseif ($string[$i] === '(') {
                $balance++;
            } elseif ($string[$i] === ')') {
                $balance--;
            }
        }
        return empty($balance);
    }

    public function check(string $string): bool
    {
        if (empty($string)) {
            return false;
        }
        return $this->balanceOk($string);
    }
}
