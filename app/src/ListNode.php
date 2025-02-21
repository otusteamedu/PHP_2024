<?php

namespace Anatolyshilyaev\App;

require '../vendor/autoload.php';

// Definition for a singly-linked list.
class ListNode
{
    public $val = 0;
    public $next = null;
    public function __construct($val)
    {
        $this->val = $val;
    }
}
