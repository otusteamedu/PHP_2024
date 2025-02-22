<?php

namespace Src;

class Fraction {
    public static function fractionToDecimal($numerator, $denominator) {
        if ($denominator === 0) {
            throw new \InvalidArgumentException("Denominator cannot be zero.");
        }

        // Обработка знака
        $result = '';
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result .= '-';
        }

        // Приведение к абсолютным значениям
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        // Целая часть
        $result .= intdiv($numerator, $denominator);
        $remainder = $numerator % $denominator;

        if ($remainder === 0) {
            return $result; // Нет дробной части
        }

        $result .= '.';

        // Хэш-таблица для отслеживания остатков и их позиций
        $map = [];
        while ($remainder !== 0) {
            if (isset($map[$remainder])) {
                // Повторяющаяся часть найдена
                $result = substr($result, 0, $map[$remainder]) . '(' . substr($result, $map[$remainder]) . ')';
                return $result;
            }

            // Сохраняем позицию текущего остатка
            $map[$remainder] = strlen($result);

            // Умножаем остаток на 10 и добавляем следующую цифру
            $remainder *= 10;
            $result .= intdiv($remainder, $denominator);
            $remainder %= $denominator;
        }

        return $result;
    }
}