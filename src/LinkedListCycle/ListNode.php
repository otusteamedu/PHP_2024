<?php

namespace KRudenko\Otus\LinkedListCycle;

class ListNode
{
    public int $val = 0;
    public ?ListNode $next = null;

    public function __construct(int $val)
    {
        $this->val = $val;
    }
}
