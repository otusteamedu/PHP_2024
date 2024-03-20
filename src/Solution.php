<?php

declare(strict_types=1);

namespace AIgnatova\MergeTwoSortedLists;

use AIgnatova\MergeTwoSortedLists\ListNode;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */

    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $listNode = new ListNode();
        $item = $listNode;

        while (!empty($list1) && !empty($list2)) {
            if ($list1->val > $list2->val) {
                $item->next = new ListNode($list2->val);
                $item = $item->next;
                $list2 = $list2->next;
            } else {
                $item->next = new ListNode($list1->val);
                $item = $item->next;
                $list1 = $list1->next;
            }
        }

        if (!empty($list1)) {
            $item->next = $list1;
        } else {
            $item->next = $list2;
        }

        return $listNode->next;
    }
}


