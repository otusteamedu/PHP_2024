<?php

use KRudenko\Otus\LetterCombinationsOfAPhoneNumber\Solution;

require __DIR__ . "/vendor/autoload.php";

$testCases = [
    [
        'digits' => '',
        'expected' => [],
        'name' => 'Пустая строка'
    ],
    [
        'digits' => '2',
        'expected' => ['a', 'b', 'c'],
        'name' => 'Одна цифра (2)'
    ],
    [
        'digits' => '23',
        'expected' => ['ad', 'ae', 'af', 'bd', 'be', 'bf', 'cd', 'ce', 'cf'],
        'name' => 'Две цифры (23)'
    ],
    [
        'digits' => '9',
        'expected' => ['w', 'x', 'y', 'z'],
        'name' => 'Одна цифра (9)'
    ],
    [
        'digits' => '7',
        'expected' => ['p', 'q', 'r', 's'],
        'name' => 'Одна цифра (7)'
    ],
    [
        'digits' => '234',
        'expected' => [
            'adg', 'adh', 'adi',
            'aeg', 'aeh', 'aei',
            'afg', 'afh', 'afi',
            'bdg', 'bdh', 'bdi',
            'beg', 'beh', 'bei',
            'bfg', 'bfh', 'bfi',
            'cdg', 'cdh', 'cdi',
            'ceg', 'ceh', 'cei',
            'cfg', 'cfh', 'cfi'
        ],
        'name' => 'Три цифры (234)'
    ]
];

// Проверка
$solution = new Solution();
foreach ($testCases as $case) {
    $result = $solution->letterCombinations($case['digits']);

    $isValid = count(array_diff($result, $case['expected'])) === 0 &&
        count(array_diff($case['expected'], $result)) === 0;

    echo $case['name'] . ": " . ($isValid ? 'Верно' : 'Неверно') . "\n";
}
