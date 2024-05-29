<?php

declare(strict_types=1);

namespace VictoriaBabikova\IntersectionNode;

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct(int $val, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
