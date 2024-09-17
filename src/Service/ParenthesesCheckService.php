<?php

declare(strict_types=1);

namespace App\Service;

final class ParenthesesCheckService
{
    public function check(string $string): bool
    {
        $openingSymbol = '(';
        $closingSymbol = ')';
        $str = $string;
        $result = 0;

        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] === $openingSymbol) {
                $result++;
            } elseif ($str[$i] === $closingSymbol) {
                $result--;
            }
            if ($result < 0) {
                break;
            }
        }

        return $result === 0;
    }
}
