<?php

namespace Dsergei\Hw8;

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct(int $val = 0, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
