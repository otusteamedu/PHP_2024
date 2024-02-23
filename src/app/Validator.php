<?php

declare(strict_types=1);

namespace AShutov\Hw4;

class Validator
{
    /**
     * @param string $string
     * @throws \Exception
     */
    public function check(string $string): void
    {
        if (empty($string)) {
            throw new \Exception("параметр 'string' не передан или пустой");
        }

        $bracketsArr = str_split($string);
        $stack = [];

        foreach ($bracketsArr as $bracket) {
            if ($bracket === '(') {
                $stack[] = $bracket;
            } elseif ($bracket === ')' && count($stack) > 0) {
                array_pop($stack);
            } else {
                throw new \Exception("неверный формат строки");
            }
        }

        if (!empty($stack)) {
            throw new \Exception("неверный формат строки");
        }
    }
}
