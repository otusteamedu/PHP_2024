<?php

// Обоснованная сложность O(n)

//phpcs:ignore
class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

//phpcs:ignore
class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {
        $head = new ListNode();
        $current = $head;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }

            $current = $current->next;
        }

        $current->next = $list1 !== null ? $list1 : $list2;

        return $head->next;
    }
}
