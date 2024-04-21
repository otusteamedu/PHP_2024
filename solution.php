<?php
class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution {
    function mergeTwoLists($list1, $list2)
    {
        if (!$list2) return $list1;
        if (!$list1) return $list2;
        if ($list1->val < $list2->val) {
            $mergedList = new ListNode($list1->val);
            $list1 = $list1->next;
        } else {
            $mergedList = new ListNode($list2->val);
            $list2 = $list2->next;
        }

        $lastNode = $mergedList;
        while (!is_null($list1) && !is_null($list2)) {
            if ($list1->val < $list2->val) {
                $nextValue = $list1->val;
                $list1 = $list1->next;
            } else {
                $nextValue = $list2->val;
                $list2 = $list2->next;
            }

            $lastNode->next = new ListNode($nextValue);
            $lastNode = $lastNode->next;
        }

        if ($list1) {
            $lastNode->next = $list1;
        } elseif ($list2) {
            $lastNode->next = $list2;
        }

        return $mergedList;
    }
}


//test:
$firstList = new ListNode(1, new ListNode(2, new ListNode(4)));
$secondList = new ListNode(1, new ListNode(3, new ListNode(4)));

$solutionObj = new Solution();
$answer = $solutionObj->mergeTwoLists($firstList, $secondList);

var_dump($answer);