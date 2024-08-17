<?php

namespace Otus;

class ListNode
{
    public $val = 0;
     public $next = null;

    public function __construct($val, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
