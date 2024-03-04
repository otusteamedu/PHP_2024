<?php

declare(strict_types=1);

namespace Lrazumov\Hw10;

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}
