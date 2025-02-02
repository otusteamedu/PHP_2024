<?php

require __DIR__ . '/autoload.php';

// Функция для слияния двух отсортированных связных списков в один отсортированный список.
// Определение класса для узла связного списка
class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

/**
 * Алгоритм:
 * 1. Создаем фиктивный узел, который будет служить началом нового списка.
 * 2. Используем указатель `current` для построения нового списка.
 * 3. Итерируемся по обоим спискам, сравнивая значения узлов:
 *    - Если значение узла из `list1` меньше, добавляем его в новый список и перемещаем указатель `list1`.
 *    - Иначе добавляем узел из `list2` и перемещаем указатель `list2`.
 * 4. После завершения одного из списков добавляем оставшиеся узлы из другого списка.
 * 5. Возвращаем голову нового списка (следующий узел после фиктивного).
 *
 * Сложность:
 * - Временная сложность: O(n + m), где n и m — длины двух связных списков.
 *   Мы проходим по каждому узлу обоих списков ровно один раз.
 * - Пространственная сложность: O(1). Мы используем только константное количество дополнительной памяти
 *   для хранения фиктивного узла и указателя на текущий узел. Новый список формируется путем изменения ссылок,
 *   а не создания новых узлов.
 */
function mergeTwoLists($list1, $list2)
{
    // Создаем фиктивный узел
    $dummy = new ListNode();
    $current = $dummy;

    // Итерируемся по обоим спискам
    while ($list1 !== null && $list2 !== null) {
        if ($list1->val < $list2->val) {
            $current->next = $list1;
            $list1 = $list1->next;
        } else {
            $current->next = $list2;
            $list2 = $list2->next;
        }
        $current = $current->next;
    }
    // Добавляем оставшиеся узлы из list1 или list2
    if ($list1 !== null) {
        $current->next = $list1;
    } else {
        $current->next = $list2;
    }
    // Возвращаем голову нового списка
    return $dummy->next;
}


// Функция для вывода списка
function printList($node) {
    $result = [];
    while ($node !== null) {
        $result[] = $node->val;
        $node = $node->next;
    }
    echo "[" . implode(", ", $result) . "]\n";
}

// Пример 1
$list1 = new ListNode(1, new ListNode(2, new ListNode(4)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4)));

echo "Пример 1:\n";
echo "Input: list1 = ";
printList($list1);
echo "Input: list2 = ";
printList($list2);

$mergedList = mergeTwoLists($list1, $list2);
echo "Output: ";
printList($mergedList); // Вывод: [1, 1, 2, 3, 4, 4]

// Пример 2
$list1 = null;
$list2 = null;

echo "\nПример 2:\n";
echo "Input: list1 = ";
printList($list1);
echo "Input: list2 = ";
printList($list2);

$mergedList = mergeTwoLists($list1, $list2);
echo "Output: ";
printList($mergedList); // Вывод: []

// Пример 3
$list1 = null;
$list2 = new ListNode(0);

echo "\nПример 3:\n";
echo "Input: list1 = ";
printList($list1);
echo "Input: list2 = ";
printList($list2);

$mergedList = mergeTwoLists($list1, $list2);
echo "Output: ";
printList($mergedList); // Вывод: [0]
?>