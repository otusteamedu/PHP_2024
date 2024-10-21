<?php

namespace VSukhov\Hw8\App;

class NodeList
{
    public int $val = 0;
    public ?NodeList $next = null;

    public function __construct(int $val = 0, NodeList $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
