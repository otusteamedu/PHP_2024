<?php

namespace VladimirGrinko\List;

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct(int $val = 0, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }

    public function print(?ListNode $head): void
    {
        if ($head === null) {
            return;
        }
        echo $head->val . PHP_EOL;
        if ($head->next !== null) {
            $this->print($head->next);
        }
    }
}
