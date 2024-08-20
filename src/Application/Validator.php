<?php

declare(strict_types=1);

namespace PavelMiasnov\Hw4;

use InvalidArgumentException;

class Validator
{
    /**
     * @param $string
     * @return bool
     */
    public static function validate(string $input) : bool
    {
        if (empty($input)) {
            throw new InvalidArgumentException('Empty string');
        }
        $input = str_split($input);
        $stack = [];
        foreach ($input as $value) {
            switch ($value) {
                case '(':
                    $stack[] = 0;
                    break;
                case ')':
                    if (array_pop($stack) !== 0) {
                        throw new InvalidArgumentException('Closing braces count is too much');
                    }
                    break;
            }
        }
        if (!empty($stack)) {
            throw new InvalidArgumentException('Opennig braces count is too much');
        }
        return true;
    }
}
