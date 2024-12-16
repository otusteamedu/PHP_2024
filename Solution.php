<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        // инициализируем головной элемент результирующего списка и текущий (последний) элемент результирующего списка
        $head = $currentNode = null;

        // перебираем списки до тех пор, пока оба не переберем полностью
        while ($list1 !== null || $list2 !== null) {

            // если список 1 непустой и его первое значение меньше первого значения списка 2 или список 2 пуст
            if ($list1 !== null && ($list2 === null || $list1->val <= $list2->val)) {

                if ($currentNode == null) { // если это самое начало и в результирующем списке еще нет элементов
                    $head = $currentNode = $list1; // началу списка и текущему элементу присваиваем первый элемент из списка 1
                } else {  // в результирующем списке уже что-то есть
                    $currentNode->next = $list1;  // добавляем в результирующий список первый элемент списка 1
                    $currentNode = $currentNode->next; // делаем текущим элементом результирующего списка его последний элемент
                }
                $list1 = $list1->next; // начало списка 1 сдвигаем на следующий элемент
            } else {
                if ($currentNode == null) {  // если это самое начало и в результирующем списке еще нет элементов
                    $head = $currentNode = $list2; // началу списка и текущему элементу присваиваем первый элемент из списка 2
                } else {  // в результирующем списке уже что-то есть
                    $currentNode->next = $list2;  // добавляем в результирующий список первый элемент списка 2
                    $currentNode = $currentNode->next; // делаем текущим элементом результирующего списка его последний элемент
                }
                $list2 = $list2->next; // начало списка 2 сдвигаем на следующий элемент
            }
        }
        return $head;
    }

    function showList($list)
    {
        $res = [];
        while ($list !== null) {
            $res[] = $list->val;
            $list = $list->next;
        }

        return implode(', ', $res);
    }
}
