<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusMergeListApp;

class ListNode
{
    /** @var int|null */
    public ?int $val = 0;

    /** @var ListNode|null */
    public ?ListNode $next = null;

    public function __construct(?int $val = 0, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
