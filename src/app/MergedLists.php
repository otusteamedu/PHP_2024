<?php

declare(strict_types=1);

namespace App;

class MergedLists
{
    public static function mergeTwoLists(?ListNode $list1 = null, ?ListNode $list2 = null): ?ListNode
    {
        if ($list1 == null || $list2 == null) {
            return $list1 ?? $list2;
        }

        $head = null;

        if ($list1->val < $list2->val) {
            $head = $list1;
            $head->next = static::mergeTwoLists($list1->next, $list2);
        } else {
            $head = $list2;
            $head->next = static::mergeTwoLists($list1, $list2->next);
        }

        return $head;
    }
}
