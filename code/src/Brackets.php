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
        if ($string[0] === ')') {
            throw new \Exception('Ошибка первой скобки', 400);
        }
        if ($string[$strLength - 1] === '(') {
            throw new \Exception('Ошибка последней скобки', 400);
        }
        if ($strLength % 2 !== 0) {
            throw new \Exception('Количество скобок не чётное', 400);
        }
        $countBracketsInString = substr_count($string, '()');
        if ($countBracketsInString == 0) {
            throw new \Exception('В строке нет первой закрытой пары', 400);
        }
        //Предельно возможное количество проходов цикла
        $counter = $strLength / 2;
        while ($counter > 0) {
            $counter--;
            $string = str_ireplace('()', '', $string);
            //Проверка остались ли еще закрытые пары
            $countBracketsInString = substr_count($string, '()');
            if ($countBracketsInString == 0) {
                break;
            }
        }
        if (strlen($string) > 0) {
            throw new \Exception('В строке не все скобки имеют пару. Те что остались ' . $string, 400);
        } else {
            return 'Строка состоит из полностью закрытых скобок. ' . $counter;
        }
    }
}
