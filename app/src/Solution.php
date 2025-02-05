<?php

namespace SlavaMakhov\OtusLeetcodeApp;

class Solution
{
    /**
     * Метод возвращает дробь в строковом формате
     *
     * @param int $numerator
     * @param int $denominator
     *
     * @return String
     */
    public static function fractionToDecimal(int $numerator, int $denominator): string
    {
        // Если $numerator равен 0, то возвращаем "0"
        if ($numerator == 0) {
            return "0";
        }

        $result = [];

        // Если один из параметров меньше 0, то добавляем "-" в результат
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result[] = "-";
        }

        // Приводим значения в переменных в положительное значение числа
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        // Возвращает результат деления переменных в целочисленном значении строкой
        $result[] = strval(intval($numerator / $denominator));
        // Остаток от деления
        $remainder = $numerator % $denominator;

        // Если числа делятся без остатка, то возвращаем результат в виде строки
        if ($remainder == 0) {
            return implode('', $result);
        }

        // Если числа не делятся без остатка, то добавляем точку в массив
        $result[] = ".";

        $map = [];
        // Итерируем пока изначальный остаток не будет равен 0
        while ($remainder != 0) {
            if (isset($map[$remainder])) {
                $result[] = ")";
                array_splice($result, $map[$remainder], 0, "(");
                break;
            }

            $map[$remainder] = count($result);

            // Каждую итерацию умножаем остаток на 10
            $remainder *= 10;
            $result[] = strval(intval($remainder / $denominator));
            $remainder %= $denominator;
        }

        return implode('', $result);
    }

    /**
     * Метод выводит значение, на котором
     * два связанных списка пересекаются
     *
     * @param ListNode $headA
     * @param ListNode $headB
     *
     * @return ?int
     */
    public static function getIntersectionNode(ListNode $headA, ListNode $headB): ?int
    {
        // Создаем переменные, которые указвают на наши списки
        $paramA = $headA;
        $paramB = $headB;

        // Итерируем пока перменные не будут равны или не дойдут до конца списка
        while ($paramA !== $paramB) {
            // Если переменная $paramA доходит до конца, то она начинает равняться
            // второму связанному списку $headB
            $paramA = $paramA === null ? $headB : $paramA->next;

            // Если переменная $paramB доходит до конца, то она начинает равняться
            // первому связанному списку $headA
            $paramB = $paramB === null ? $headA : $paramB->next;
        }

        // Возвращаем значение где списки пересекаются
        return $paramA->val ?? null;
    }
}
