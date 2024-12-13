<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    static function mergeTwoLists($list1, $list2)
    {
        //Определяем какая нода первая - какое значение меньше с той и будет строиться спиок
        if ($list1->val > $list2->val) {
            $nextNodeList1 = $list2;
            $nextNodeList2 = $list1;
        } else {
            $nextNodeList1 = $list1;
            $nextNodeList2 = $list2;
        }

        $startNode = $nextNodeList1;

        while (!is_null($nextNodeList2)) {

            if ($nextNodeList2->val >= $nextNodeList1->val && !is_null($nextNodeList1->next) && $nextNodeList2->val > $nextNodeList1->next->val) {
                $nextNodeList1 = $nextNodeList1->next;
                continue;
            }

            $next = $nextNodeList1->next;
            $nextNodeList1->next = new ListNode($nextNodeList2->val, $next);

            $nextNodeList2 = $nextNodeList2->next;
        }

        return $startNode;
    }
}