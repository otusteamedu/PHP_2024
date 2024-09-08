<?php

namespace PenguinAstronaut\App;

use PenguinAstronaut\App\Exceptions\EmptyStringException;
use PenguinAstronaut\App\Exceptions\InvalidStringException;

class Validator
{
    /**
     * @throws EmptyStringException
     * @throws InvalidStringException
     */
    public function validateString(string $string): true
    {
        if (!$string) {
            throw new EmptyStringException('Empty string');
        }

        if (!str_contains($string, '(')) {
            throw new InvalidStringException('Invalid string');
        }

        if (count($this->parseString($string))) {
            throw new InvalidStringException('Invalid string');
        }

        return true;
    }

    /**
     * @throws InvalidStringException
     */
    private function parseString(string $string): array
    {
        $charList = str_split($string);
        $stack = [];

        foreach ($charList as $char) {
            if ($char === ')' && empty($stack)) {
                throw new InvalidStringException('Invalid string');
            } elseif ($char === ')' && end($stack) !== '(') {
                throw new InvalidStringException('Invalid string');
            } elseif ($char === ')') {
                array_pop($stack);
            } elseif ($char === '(') {
                $stack[] = $char;
            }
        }

        return $stack;
    }
}
