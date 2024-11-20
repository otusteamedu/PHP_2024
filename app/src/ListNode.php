<?php

declare(strict_types=1);

namespace Otus\Hw14;

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}
