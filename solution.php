<?php

declare(strict_types=1);

namespace Otus\MergeTwoLists;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        $res = new ListNode();
        $head = $res;
        while ($list1 || $list2) {
            if ($list1 === null) {
                $head->next = $list2;
                break;
            }
            if ($list2 === null) {
                $head->next = $list1;
                break;
            }
            if ($list1->val <= $list2->val) {
                $head->next = $list1;
                $list1 = $list1->next;
            } else {
                $head->next = $list2;
                $list2 = $list2->next;
            }
            $head = $head->next;
        }
        $res = $res->next;
        return $res;
    }
}
