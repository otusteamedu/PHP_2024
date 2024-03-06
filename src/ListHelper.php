<?php

declare(strict_types=1);

namespace Afilipov\Hw8;

class ListHelper
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if ($list1 === null) {
            return $list2;
        }

        if ($list2 === null) {
            return $list1;
        }

        $dummyHead = new ListNode();
        $tail = $dummyHead;

        while ($list1 !== null && $list2 !== null) {
            $tail->next = ($list1->val < $list2->val) ? $list1 : $list2;

            if ($list1->val < $list2->val) {
                $list1 = $list1->next;
            } else {
                $list2 = $list2->next;
            }

            $tail = $tail->next;
        }

        $tail->next = $list1 ?? $list2;

        return $dummyHead->next;
    }
}
