<?php

declare(strict_types=1);

namespace Afilipov\Hw8;

class ListNode
{
    public int $val;
    public ?ListNode $next;

    public function __construct(int $val = 0, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
