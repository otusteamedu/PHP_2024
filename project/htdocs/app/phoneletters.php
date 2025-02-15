<?php
// ./app/phone_letters.php

function letterCombinations($digits) {
    if (empty($digits)) {
        return [];
    }

    // Соответствие цифр и букв
    $digitToLetters = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z'],
    ];

    $result = [''];  // Инициализация с пустой строкой

    // Проходим по каждой цифре
    for ($i = 0; $i < strlen($digits); $i++) {
        $currentDigit = $digits[$i];
        $letters = $digitToLetters[$currentDigit];
        $newResult = [];

        // Для каждой существующей комбинации добавляем новую букву
        foreach ($result as $combination) {
            foreach ($letters as $letter) {
                $newResult[] = $combination . $letter;
            }
        }

        $result = $newResult;  // Обновляем результат
    }

    return $result;
}