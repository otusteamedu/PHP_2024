<?php

declare(strict_types=1);

namespace Otus\MergeTwoLists;

class ListNode
{
    public $val = 0;
    public $next = null;
    protected function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
