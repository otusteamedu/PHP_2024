<?php

namespace PenguinAstronaut\App;

use PenguinAstronaut\App\Exceptions\EmptyStringException;
use PenguinAstronaut\App\Exceptions\InvalidStringException;

class Parser
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

        $stringParsedItemCount = count($this->parseString($string));

        if (!$stringParsedItemCount || $stringParsedItemCount % 2 !== 0) {
            throw new InvalidStringException('Invalid string');
        }

        return true;
    }

    /**
     * @throws InvalidStringException
     */
    private function parseString(string $string): array
    {
        $charList = explode('', $string);
        $stack = [];

        foreach ($charList as $char) {
            if ($char === ')' && !empty($stack)) {
                throw new InvalidStringException('Invalid string');
            } elseif ($char === ')' && end($stack) !== '(') {
                throw new InvalidStringException('Invalid string');
            } elseif ($char === '(') {
                $stack[] = $char;
            }
        }

        return $stack;
    }
}
