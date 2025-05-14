<?php

declare(strict_types=1);


class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val = 0, $next = null)
    {
        $this->val  = $val;
        $this->next = $next;
    }
}

// Сложность линейная о(x) так как проходимся одним циклом по обоим спискам
class Solution
{

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        if ($list1 === null) {
            return $list2;
        }
        if ($list2 === null) {
            return $list1;
        }

        $result  = new ListNode();
        $newList = $result;

        if ($list1->val > $list2->val) {
            $newList->val = $list2->val;
            $list2        = $list2->next;
        } else {
            $newList->val = $list1->val;
            $list1        = $list1->next;
        }

        while ($list2 !== null) {


            if ($list1 === null) {
                $newList->next = $list2;
                break;
            }


            $newList->next = new ListNode();
            $newList       = $newList->next;

            if ($list1->val > $list2->val) {
                $newList->val = $list2->val;
                $list2        = $list2->next;
            } else {
                $newList->val = $list1->val;
                $list1        = $list1->next;
            }


        }

        if ($list1 !== null) {
            $newList->next = $list1;

        }
        return $result;
    }
}