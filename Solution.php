<?php

declare(strict_types=1);

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution
{
    /**
     * Сложность по времени: O(N), N = количество элементов (в обоих списках).
     * Сложность по памяти: O(1), т.к. у нас определенное кол-во переменных.
     */
    public function mergeTwoLists($list1, $list2)
    {
        // Дефолтный результирующий список
        $result = new ListNode();
        $current = $result; // Указатель на текущий список

        // Перебираем входящие списки, если они не пусты
        while ($list1 !== null && $list2 !== null) {
            // Определяем наименьшее из двух текущих значений в списках и присвоим его в наш список
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }

            // Сдвигаем текущий указатель нашего списка на следующий элемент
            $current = $current->next;
        }

        // Если что-то остается или один из входящих списков пуст, то просто добавим эти элементы в наш список
        if ($list1 !== null) {
            $current->next = $list1;
        } elseif ($list2 !== null) {
            $current->next = $list2;
        }

        // Т.к. мы объявляли результирующий список, то результат сортировки начинается с next
        return $result->next;
    }
}