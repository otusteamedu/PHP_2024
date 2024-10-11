<?php
namespace LinkedListCycle;

class ListNode
{
    public int $val = 0;
    public $next = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}
