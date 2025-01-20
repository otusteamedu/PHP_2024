<?php

class ListNode
{
    public $val = 0;
    public $next = null;
    function __construct($val)
    {
        $this->val = $val;
    }
}

//Сложность O(n), т.к. осуществляется проход по всему списку не более двух раз.
class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head)
    {
        $slow = $head;
        $fast = $head;

        while ($fast !== null && $fast->next !== null) {
            $slow = $slow->next; // Медленный указатель перемещается на 1 шаг
            $fast = $fast->next->next; // Быстрый указатель перемещается на 2 шага

            if ($slow === $fast) {
                return true; // Если указатели встретились, значит, есть цикл
            }
        }

        // Если дошли до конца списка, цикла нет
        return false;
    }
}

// Пример использования
$node1 = new ListNode(1);
$node2 = new ListNode(2);
$node3 = new ListNode(3);
$node4 = new ListNode(4);

$node1->next = $node2;
$node2->next = $node3;
$node3->next = $node4;
$node4->next = $node2; // Создаем цикл

$solution = new Solution();
echo $solution->hasCycle($node1) ? "Cycle detected" : "No cycle";
