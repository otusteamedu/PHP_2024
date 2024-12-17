<?php

namespace Otus2024;

use Otus2024\ListNode;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        $dummy = new ListNode(-1);
        $current = $dummy;

        // Пока оба списка не пусты
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

        // Если остались элементы в одном из списков, добавляем их
        if ($list1 !== null) {
            $current->next = $list1;
        } else {
            $current->next = $list2;
        }

        // Возвращаем результирующий список, начиная со следующего после фиктивного узла
        return $dummy->next;
    }
}
