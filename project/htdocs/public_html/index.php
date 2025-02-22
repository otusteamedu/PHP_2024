<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Src\ListNode;
use Src\LinkedList;
use Src\Fraction;

// Вспомогательная функция для создания связанных списков
function createLinkedList(array $values) {
    $dummy = new ListNode(0); // Фиктивный узел
    $current = $dummy;
    foreach ($values as $value) {
        $current->next = new ListNode($value);
        $current = $current->next;
    }
    return $dummy->next; // Возвращаем голову списка
}

// Пример 1
echo "Пример 1:\n";
$common1 = new ListNode(8, new ListNode(4, new ListNode(5)));
$listA1 = new ListNode(4, new ListNode(1, $common1));
$listB1 = new ListNode(5, new ListNode(6, new ListNode(1, $common1)));
$result1 = LinkedList::getIntersectionNode($listA1, $listB1);
if ($result1 !== null) {
    echo "Пересечение в узле '{$result1->val}'\n";
} else {
    echo "Нет пересечения\n";
}

// Пример 2
echo "\nПример 2:\n";
$common2 = new ListNode(2, new ListNode(4));
$listA2 = new ListNode(1, new ListNode(9, new ListNode(1, $common2)));
$listB2 = new ListNode(3, $common2);
$result2 = LinkedList::getIntersectionNode($listA2, $listB2);
if ($result2 !== null) {
    echo "Пересечение в узле '{$result2->val}'\n";
} else {
    echo "Нет пересечения\n";
}

// Пример 3
echo "\nПример 3:\n";
$listA3 = new ListNode(2, new ListNode(6, new ListNode(4)));
$listB3 = new ListNode(1, new ListNode(5));
$result3 = LinkedList::getIntersectionNode($listA3, $listB3);
if ($result3 !== null) {
    echo "Пересечение в узле '{$result3->val}'\n";
} else {
    echo "Нет пересечения\n";
}

// Пример 1
$numerator1 = 1;
$denominator1 = 2;
echo "Пример 1: " . Fraction::fractionToDecimal($numerator1, $denominator1) . "\n"; // Output: "0.5"

// Пример 2
$numerator2 = 2;
$denominator2 = 1;
echo "Пример 2: " . Fraction::fractionToDecimal($numerator2, $denominator2) . "\n"; // Output: "2"

// Пример 3
$numerator3 = 4;
$denominator3 = 333;
echo "Пример 3: " . Fraction::fractionToDecimal($numerator3, $denominator3) . "\n"; // Output: "0.(012)"