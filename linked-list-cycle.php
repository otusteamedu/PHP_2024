<?php

use KRudenko\Otus\LinkedListCycle\ListNode;
use KRudenko\Otus\LinkedListCycle\Solution;

require __DIR__ . "/vendor/autoload.php";

/**
 * Генерирует связный список. Если $pos передать -1, то будет список без цикла.
 */
function createListNode(array $values, int $pos): ?ListNode {
    if (empty($values)) return null;

    $head = new ListNode($values[0]);
    $current = $head;
    $cycleNode = null;

    for ($i = 0; $i < count($values); $i++) {
        if ($i === $pos) {
            $cycleNode = $current;
        }
        if ($i < count($values) - 1) {
            $current->next = new ListNode($values[$i + 1]);
            $current = $current->next;
        }
    }

    $current->next = $cycleNode;

    return $head;
}

$testCases = [
    [
        'list' => createListNode([1, 2, 3, 4], -1),
        'expected' => false,
        'name' => 'Обычный список без цикла'
    ],
    [
        'list' => createListNode([1, 2, 3, 4], 1),
        'expected' => true,
        'name' => 'Список с циклом (4 -> 2)'
    ],
    [
        'list' => createListNode([5], -1),
        'expected' => false,
        'name' => 'Список из одного элемента без цикла'
    ],
    [
        'list' => createListNode([5], 0), // 5 -> 5
        'expected' => true,
        'name' => 'Список из одного элемента с циклом'
    ],
    [
        'list' => createListNode([1, 2], 0),
        'expected' => true,
        'name' => 'Маленький цикл (2 -> 1)'
    ],
    [
        'list' => createListNode([-21,10,17,8,4,26,5,35,33,-7,-16,27,-12,6,29,-12,5,9,20,14,14,2,13,-24,21,23,-21,5], -1),
        'expected' => false,
        'name' => 'Большой список без цикла с повторениями значений'
    ],
    [
        'list' => createListNode([-21,10,17,8,4,26,5,35,33,-7,-16,27,-12,6,29,-12,5,9,20,14,14,2,13,-24,21,23,-21,5], 5),
        'expected' => true,
        'name' => 'Большой список с циклом с повторениями значений'
    ]
];

// Проверка
$solution = new Solution();
foreach ($testCases as $case) {
    $result = $solution->hasCycle($case['list']);
    echo $case['name'] . ": " . ($result === $case['expected'] ? 'Верно' : 'Неверно') . "\n";
}
