<?php

class CheckerBracket
{
    /**
     * @throws Exception
     */
    public function ckeckBrackets(string $bracketsStr): bool
    {
        $correctedString = $this->checkBracketsString($bracketsStr);

        if (!$correctedString) {
            throw new Exception('Строка некорректна');
        }

        $brackets = $this->getBracketsFromString($bracketsStr);

        if (count($brackets) < 2) throw new Exception('Количество скобок меньше 1');
        if (!$this->isOpen($brackets[0])) throw new Exception('Первая скобка не открывающая');
        if (!$this->isClosed($brackets[count($brackets) - 1])) throw new Exception('Последняя скобка не закрывающая');

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
            throw new Exception('Скобки расставлены некорректно');
        }

        return true;
    }

    private function getBracketsFromString(string $str): array
    {
        return str_split($str);
    }

    private function checkBracketsString(string $str)
    {
        return (bool)preg_match('/^[()]+$/', $str);
    }

    private function isOpen($bracket): bool
    {
        return $bracket === '(';
    }

    private function isClosed($bracket): bool
    {
        return $bracket === ')';
    }
}