<?php

require_once __DIR__ . '/../app/linkedlist.php';
require_once __DIR__ . '/../app/phone_letters.php';

// Пример 1: Проверка наличия цикла в связанном списке
echo "<h3>Пример 1: Проверка наличия цикла в связанном списке</h3>";
$node1 = new ListNode(3);
$node2 = new ListNode(2);
$node3 = new ListNode(0);
$node4 = new ListNode(-4);

$node1->next = $node2;
$node2->next = $node3;
$node3->next = $node4;
$node4->next = $node2;

$result = hasCycle($node1);
echo "Результат: " . ($result ? 'true' : 'false') . "<br>";  // Ожидаемый вывод: true

// Пример 2: Генерация комбинаций букв для цифр
echo "<h3>Пример 2: Генерация комбинаций букв для цифр</h3>";
$digits = "23";
$combinations = letterCombinations($digits);
echo "Цифры: $digits<br>";
echo "Комбинации: " . implode(", ", $combinations) . "<br>";  // Ожидаемый вывод: ad, ae, af, bd, be, bf, cd, ce, cf