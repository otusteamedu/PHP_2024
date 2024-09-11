<?php

namespace AlexAgapitov\OtusComposerProject;

class Solution
{
    public static function mergeTwoLists(?ListNode $list1, ?ListNode $list2) : ?ListNode
    {
        if (is_null($list1) && is_null($list2)) return null;
        if (is_null($list1)) return $list2;
        if (is_null($list2)) return $list1;

        if (!self::checkVal($list1->val) || !self::checkVal($list2->val)) return null;

        $length1 = $length2 = 0;
        
        if ($list1->val <= $list2->val) {
            $length1++;
            $res = $head = new ListNode($list1->val);
            $list1 = $list1->next;
        } else {
            $length2++;
            $res = $head = new ListNode($list2->val);
            $list2 = $list2->next;
        }

        while ($list1 !== null && $list2 !== null) {
            if (!self::checkVal($list1->val) || !self::checkVal($list2->val)) return null;

            if ($list1->val <= $list2->val) {
                if (!self::checkLength(++$length1)) return null;
                $head->next = new ListNode($list1->val);
                $list1 = $list1->next;
            } else {
                if (!self::checkLength(++$length2)) return null;
                $head->next = new ListNode($list2->val);
                $list2 = $list2->next;
            }
            $head = $head->next;
        }

        return $res;
    }

    private static function checkVal(int $val): bool
    {
        return $val >= -100 && $val <= 100;
    }
    private static function checkLength(int $length): bool
    {
        return $length <= 50;
    }
}