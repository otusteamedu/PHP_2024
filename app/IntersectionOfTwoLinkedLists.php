<?php

// Definition for a singly-linked list.
class ListNode
{
    public $val = 0;
    public $next = null;
    function __construct($val)
    {
        $this->val = $val;
    }
}

//Сложность O(n)
class Solution
{
    /**
     * @param ListNode|null $headA
     * @param ListNode|null $headB
     * @return ListNode|null
     */
    function getIntersectionNode($headA, $headB)
    {
        $lenA = $this->getLength($headA);
        $lenB = $this->getLength($headB);

        // Выровняем длины списков
        if ($lenA > $lenB) {
            $headA = $this->moveForward($headA, $lenA - $lenB);
        } else {
            $headB = $this->moveForward($headB, $lenB - $lenA);
        }

        // Запускаем рекурсивный поиск пересечения
        return $this->findIntersection($headA, $headB);
    }

    // Функция для вычисления длины списка
    private function getLength($head)
    {
        if (!$head) return 0;
        return 1 + $this->getLength($head->next);
    }

    // Функция для выравнивания списка (удаляет лишние узлы)
    private function moveForward($head, $steps)
    {
        if ($steps == 0) return $head;
        return $this->moveForward($head->next, $steps - 1);
    }

    // Рекурсивный поиск пересечения
    private function findIntersection($headA, $headB)
    {
        if (!$headA || !$headB) return null;
        if ($headA === $headB) return $headA;
        return $this->findIntersection($headA->next, $headB->next);
    }
}
