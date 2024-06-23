<?php

declare(strict_types=1);

namespace Otus\Balancer\StringCheker;

class BracketsValidator
{
    public function validate(string $str): bool
    {
        $str = trim($str);
        if (
            strlen($str) &&
            substr($str, 0, 1) === '(' &&
            substr($str, -1) === ')' &&
            substr_count($str, '(') === substr_count($str, ')')
        ) {
            return true;
        }
        return false;
    }
}
