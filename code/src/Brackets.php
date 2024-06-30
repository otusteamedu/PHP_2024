<?php

declare(strict_types=1);

namespace Rrazanov\Hw4;

class Brackets
{
    /**
     * @throws \Exception
     */
    public function checkBrackets(string $string): string
    {
        $strLength = strlen($string);
        if ($strLength == 0) {
            throw new \Exception('Передана пустая строка', 400);
        }
        if ($string[0] === ')') {
            throw new \Exception('Ошибка первой скобки', 400);
        }
        if ($string[$strLength - 1] === '(') {
            throw new \Exception('Ошибка последней скобки', 400);
        }
        if ($strLength % 2 !== 0) {
            throw new \Exception('Количество скобок нечётное', 400);
        }
        $counterBrackets = 0;
        for ($i = 0; $i < $strLength; $i++) {
            switch ($string[$i]) {
                case '(':
                    $counterBrackets++;
                    break;
                case ')':
                    $counterBrackets--;
                    break;
                default:
                    break;
            }
            if ($counterBrackets < 0) {
                throw new \Exception('В строке не все скобки имеют пару.' . $string, 400);
            }
        }
        if ($counterBrackets === 0) {
            return 'Строка состоит из полностью закрытых скобок.';
        } else {
            throw new \Exception('В строке не все скобки имеют пару.' . $string, 400);
        }
    }
}
