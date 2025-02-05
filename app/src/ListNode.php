<?php

namespace SlavaMakhov\OtusLeetcodeApp;

class ListNode
{
    /** @var int */
    public int $val = 0;

    /** @var ListNode|null */
    public ?ListNode $next = null;

    function __construct(?int $val = 0)
    {
        $this->val = $val;
    }
}
