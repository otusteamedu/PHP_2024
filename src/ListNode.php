<?php

namespace KRudenko\Otus;

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }

    public function toArray(): array
    {
        $arr = [];
        $next = $this;
        while ($next !== null) {
            if ($next->val !== null) {
                $arr[] = $next->val;
            }
            $next = $next->next;
        }

        return $arr;
    }
}
