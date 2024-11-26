<?php

namespace VladimirGrinko\List;

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct(int $val = 0, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
