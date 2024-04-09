<?php

//Constraints:
//
//The number of nodes in both lists is in the range [0, 50].
//-100 <= Node.val <= 100
//Both list1 and list2 are sorted in non-decreasing order.


//Definition for a singly-linked list.
class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
      $this->val = $val;
      $this->next = $next;
    }
}


class Solution
{

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $list = new ListNode();
        $link = $list;

        while (!is_null($list1) && !is_null($list2)) {
            if ($list1->val <= $list2->val) {
                $link->next = $list1;
            } else {
                $link->next = $list2;
            }
            
        }
        return $list->next;
    }
}

//(new Solution())->mergeTwoLists(list1 = [1,2,4], list2 = [1,3,4]);

//$list1 = [-100,-67,0,2,4,40,78,100];
//$list2 = [-96,-78,0,1,3,4,58,90,98,99];
//
//$list = [];
//
//for ($i = 0; $i < 50; $i++) {
//    if (
//        (count($list1) == $i || count($list2) == $i) ||
//        ($list1[$i] > 100 || $list2[$i] > 100)
//    ) break;
//
//    if ($list1[$i] < -100 || $list2[$i] < -100) continue;
//
//    if ($list1[$i] >= $list2[$i]) {
//        $list[] = $list2[$i];
//        $list[] = $list1[$i];
//    } else {
//        $list[] = $list1[$i];
//        $list[] = $list2[$i];
//    }
//}
//
//print_r($list);