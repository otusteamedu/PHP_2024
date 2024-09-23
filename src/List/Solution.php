<?php

namespace VladimirGrinko\List;

use VladimirGrinko\List\ListNode;

class Solution
{
    /*
    Сложность алгоритма будет O(n). n в нашем случае равна длине самого длинного списка
    То есть, чтобы отсортировать списки при условиях задачи понадобится n итераций
    */
    public function mergeTwoLists(?ListNode $leftList, ?ListNode $rightList): ?ListNode
    {
        $head = new ListNode(); //новый список
        $lastNode = $head;

        while ($leftList !== null && $rightList !== null) {
            if ($leftList->val <= $rightList->val) {
                $lastNode->next = $leftList;
                $leftList = $leftList->next;
            } else {
                $lastNode->next = $rightList;
                $rightList = $rightList->next;
            }
            $lastNode = $lastNode->next;
        }

        if ($leftList !== null) {
            $lastNode->next = $leftList;
        } else if ($rightList !== null) {
            $lastNode->next = $rightList;
        }

        return $head->next;
    }
}
