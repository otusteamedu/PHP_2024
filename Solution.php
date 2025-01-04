<?

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
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    public static function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $result_list = new ListNode();
        $current = $result_list;

        while (!is_null($list1) && !is_null($list2)) {
            if ($list1->val <= $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }

        if ($list1 != null) {
            $current->next = $list1;
        } elseif ($list2 != null) {
            $current->next = $list2;
        }

        return $result_list->next;
    }
}