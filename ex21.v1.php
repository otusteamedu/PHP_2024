<?php

class Solution
{
    /**
     * @param ?ListNode $list1
     * @param ?ListNode $list2
     * @return ?ListNode
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2)
    {
        if(is_null($list1) || is_null($list2)) {
            return $list1 ?? $list2;
        }

        if($list1->val >= $list2->val) {
            $next2 = $list2->next;
            $list2->next = $list1;
            $list1 = $list2;
            $list2 = $next2;
        }

        $return = $list1;

        while(is_object($list1)) {
            $next1 = $list1->next;

            while(is_object($list2)) {
                $next2 = $list2->next;
                if($list2->val >= $list1->val) {
                    if(!is_object($next1)) {
                        $list1->next = $list2;
                        $list2 = $next2;
                        $list1 = $list1->next;
                    } elseif($next1->val >= $list2->val) {
                        $list2->next = $next1;
                        $list1->next = $list2;
                        $list2 = $next2;
                        $list1 = $list1->next;
                    } else {
                        $list1 = $next1;
                        break;
                    }
                } else {
                    $list1 = $next1;
                    break;
                }
            }


            if(!is_object($list2)) {
                break;
            }
        }

        return $return;
    }
}
