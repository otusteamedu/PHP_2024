<?php

declare(strict_types=1);

namespace Igor\ValidateBrackets;

use Exception;

class Validate
{
    /**
     * @throws Exception
     */
    static public function isBracketsValidate(string $brackets): bool
    {
        $count = mb_strlen($brackets);
        if ($brackets["0"] !== "(" || $brackets[--$count] !== ")") {
            throw new Exception("Не верный формат строки");
        }
        $stack = [];
        for ($i = 0; $i <= $count; $i++) {
            if ($brackets[$i] === "(") {
                $stack[] = $brackets[$i];
                continue;
            }
            if ($brackets[$i] === ")" && !empty($stack)) {
                array_pop($stack);
            } else {
                return false;
            }
        }
        if (!empty($stack)) {
            return false;
        }
        return true;
    }
}
