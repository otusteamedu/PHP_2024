<?php

declare(strict_types=1);

namespace AIgnatova\MergeTwoSortedLists;

// Definition for a singly-linked list.
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
