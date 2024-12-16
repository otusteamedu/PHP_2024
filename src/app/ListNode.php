<?php

declare(strict_types=1);

namespace App;

class ListNode
{
    function __construct(public int $val = 0, public ?ListNode $next = null)
    {
    }
}
