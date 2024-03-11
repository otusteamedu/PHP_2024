<?php

declare(strict_types=1);

namespace Alogachev\Homework;

class ListMerge
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2): ListNode
    {
        if (is_null($list1)) {
            return $list2;
        }

        if (is_null($list2)) {
            return $list1;
        }

        return $list1->val >= $list2->val
            ? new ListNode(
                $list2->val,
                !is_null($list2->next)
                    ? $this->mergeTwoLists($list1, $list2->next)
                    : $list1
            )
            : new ListNode(
                $list1->val,
                !is_null($list1->next)
                    ? $this->mergeTwoLists($list2, $list1->next)
                    : $list2
            );
    }
}
