<?php

//Сложность O(4^n), т.к. каждая цифра добавляет 3 или 4 новых комбинации.
class Solution
{
    private $phoneData = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        if (strlen($digits) === 0) {
            return []; // Если строка пуста, возвращаем пустой массив
        }

        $result = ['']; // Инициализируем массив с пустой строкой

        // Проходим по каждой цифре в строке
        foreach (str_split($digits) as $digit) {
            $newResult = [];
            $letters = $this->phoneData[(int)$digit]; // Получаем буквы для текущей цифры

            // Для каждой комбинации в текущем результате добавляем новые буквы
            foreach ($result as $combination) {
                foreach ($letters as $letter) {
                    $newResult[] = $combination . $letter;
                }
            }

            $result = $newResult; // Обновляем текущий результат
        }

        return $result;
    }
}

// Пример использования
$solution = new Solution();
print_r($solution->letterCombinations("23")); // Вывод: ["ad", "ae", "af", "bd", "be", "bf", "cd", "ce", "cf"]
print_r($solution->letterCombinations(""));   // Вывод: []
print_r($solution->letterCombinations("2"));  // Вывод: ["a", "b", "c"]
