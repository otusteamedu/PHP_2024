<?php

declare(strict_types=1);

namespace Alogachev\Homework;

class ListMerge
{
    function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {
        /*
         * Если нулевой ListNode - то это последний элемент списка.
         */
//        if ($list1->val > $list2->val) {
//            $result = new ListNode($list1->val);
//        } elseif ($list1->val < $list2->val) {
//            $result = new ListNode($list2->val);
//        } else {
//            $result = new ListNode($list1->val, $list2);
//        }

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

//        $result = null;
//
//        switch (true) {
//            case is_null($list1->next) && !is_null($list2->next):
//                $result = $this->mergeTwoLists($list1, $list2->next);
//                break;
//            case is_null($list2->next) && !is_null($list1->next):
//                $result = $this->mergeTwoLists($list1->next, $list2);
//                break;
//            case !is_null($list1->next) && !is_null($list2->next):
//                if ($list1->val > $list2->val) {
//                    $result = $this->mergeTwoLists($list1->next, $list2);
//                } elseif ($list1->val < $list2->val) {
//                    $result = $this->mergeTwoLists($list1, $list2->next);
//                } else {
//                    $result = $this->mergeTwoLists($list1->next, $list2->next);
//                }
//                break;
//        }
//
//
//
//        return $list1->val >= $list2->val
//            ? new ListNode($list1->val, $result)
//            : new ListNode($list2->val, $result);
    }
}
