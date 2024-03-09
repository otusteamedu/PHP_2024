<?php

declare(strict_types=1);

class ListNode
{
    public int $val = 0;
    public ?ListNode $next = null;

    public function __construct(int $val = 0, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution
{
    /**
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $firstNode = null;
        $previousNode = null;
        while ($list1 !== null || $list2 !== null) {
            if ($list1 !== null && $list2 !== null) {
                if ($list1->val <= $list2->val) {
                    $currentNode = $list1;
                    $list1 = $list1->next;
                } else {
                    $currentNode = $list2;
                    $list2 = $list2->next;
                }
            } else {
                if ($list1 !== null) {
                    $currentNode = $list1;
                    $list1 = $list1->next;
                } else {
                    $currentNode = $list2;
                    $list2 = $list2->next;
                }
            }

            if ($previousNode === null) {
                $firstNode = $currentNode;
            } else {
                $previousNode->next = $currentNode;
            }

            $previousNode = $currentNode;
        }

        return $firstNode;
    }
}
