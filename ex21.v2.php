<?
class Solution
{
    /**
     * @param ?ListNode $list1
     * @param ?ListNode $list2
     * @return ?ListNode
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2)
    {
        if (!is_object($list1) || !is_object($list2)) {
            return $list1 ?? $list2;
        }

        if ($list1->val <= $list2->val) {
            $res1 = $list1;
            $res2 = $list2;
        } else {
            $res1 = $list2;
            $res2 = $list1;
        }

        $next1 = $res1->next;
        $next2 = $res2->next;

        if (!is_object($next1)) {
            $res1->next = $res2;
            return $res1;
        }

        if ($next1->val >= $res2->val) {
            $res2->next = $next1;
            $res1->next = $this->mergeTwoLists($res2, $next2);
        } else {
            $res1->next = $this->mergeTwoLists($res2, $next1);
        }

        return $res1;
    }
}
