/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        if (!$list2) return $list1;
        if (!$list1) return $list2;

        $resultList = ($list1->val < $list2->val) ? ListNode($list1->val) : new ListNode($list2->val);

        if ($list1->val < $list2->val) {
            $list1 = $list1->next;
        } else {
            $list2 = $list2->next;
        };

        $nextNode = $resultList;
        while (!is_null($list1) && !is_null($list2)) {
            $nextValue = ($list1->val < $list2->val) ? $list1->val : $list2->val;
            if ($list1->val < $list2->val) {
                $list1 = $list1->next;
            } else {
                $list2 = $list2->next;
            };

            $nextNode->next = new ListNode($nextValue);
            $nextNode = $nextNode->next;
            
        };

        if ($list1) {
            $nextNode->next = $list1;
        } elseif ($list2) {
            $nextNode->next = $list2;
        }

        return $resultList;
    }
}
