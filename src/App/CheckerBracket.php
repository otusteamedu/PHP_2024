<?php

declare(strict_types=1);

namespace App;

class CheckerBracket
{
    /**
     * @throws \Exception
     */
    public function validateBrackets(string $bracketsStr): bool
    {
        $this->validateString($bracketsStr);

        $brackets = $this->getBracketsFromString($bracketsStr);

        $this->validateBracketsCounts($brackets);
        $this->validateOpenClosedBrackets($brackets);

        return true;
    }

    private function isOpen($bracket): bool
    {
        return $bracket === '(';
    }

    private function isClosed($bracket): bool
    {
        return $bracket === ')';
    }

    private function validateBracketsCounts(array $brackets)
    {
        if (count($brackets) < 2) throw new \Exception('Количество скобок меньше 2');
        if (!$this->isOpen($brackets[0])) throw new \Exception('Первая скобка не открывающая');
        if (!$this->isClosed($brackets[count($brackets) - 1])) throw new \Exception('Последняя скобка не закрывающая');

        return true;
    }

    private function validateOpenClosedBrackets(array $brackets): bool
    {
        $openedBrackets = [];
        $closedBrackets = [];

        foreach ($brackets as $bracket) {
            if ($this->isOpen($bracket)) {
                $openedBrackets[] = $bracket;
            }
            if ($this->isClosed($bracket)) {
                $closedBrackets[] = $bracket;

                if (count($openedBrackets) > 0) {
                    array_shift($openedBrackets);
                    array_shift($closedBrackets);
                }
            }
        }

        if (count($openedBrackets) > 0 || count($closedBrackets) > 0) {
            throw new \Exception('Скобки расставлены некорректно');
        }

        return true;
    }

    private function getBracketsFromString(string $str): array
    {
        return str_split($str);
    }

    private function validateString(string $str): bool
    {
        $isCorrect = (bool)preg_match('/^[()]+$/', $str);

        if (!$isCorrect) {
            throw new \Exception('Строка некорректна');
        }

        return true;
    }
}