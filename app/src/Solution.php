<?php

namespace SlavaMakhov\OtusLeetcodeApp;

class Solution
{
    /**
     * Массив с буквами, которые соответствуют цифрам
     *
     * @var array
     */
    private static array $numbersList = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'z', 'y', 'z'],
    ];

    /**
     * Метод проверяет есть ли цикл внутри списка
     *
     * @param ListNode|null $head
     *
     * @return bool
     */
    public static function hasCycle(?ListNode $head): bool
    {
        // Проверка, если параметр next пуст, то возвращем false,
        // чтобы цикл не работал в пустую
        if ($head->next === null) {
            return false;
        }

        // Иницииализируем 2 переменных, клоторые указывают головной узел
        $slow = $head;
        $fast = $head;

        // Проходим до тех пор, пока $fast или $fast->next не будут пусты
        while ($fast !== null && $fast->next !== null) {
            // Переход к next шагу
            $slow = $slow->next;
            $fast = $fast->next->next;

            // Если $slow и $fast будут равны, то возвращем true
            if ($slow === $fast) {
                return true;
            }
        }

        return false;
    }

    /**
     * Метод выводит все возможные комбинации букв
     * на основе переданной строки (например: 23)
     *
     * @param String $digits
     *
     * @return array
     */
    public static function letterCombinations(string $digits): array
    {
        $digistLen = strlen($digits);
        // Если переданная строка $digits пуста, то возвращаем пустой массив
        if ($digistLen === 0 || $digistLen > 4) {
            return [];
        }

        // Массив с возможными комбинациями
        $resultCombinations = [''];

        // Проходимся циклом, пока $i не будет меньше длины переданной строки $digits
        for ($i = 0; $i < $digistLen; $i++) {
            // Массив с временными комбинациями
            $tempCombinations = [];
            // Получение букв по переданному числу
            $charsByNumber = self::$numbersList[$digits[$i]];


            // Проходимся в цикле по всем буквам, которые соответвуют переданным числам
            foreach ($resultCombinations as $combination) {
                foreach ($charsByNumber as $char) {
                    $tempCombinations[] = $combination . $char;
                }
            }

            // Временные комбинации переносим в итоговый массив
            $resultCombinations = $tempCombinations;
        }

        return $resultCombinations;
    }
}
