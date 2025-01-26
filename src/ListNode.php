<?php

namespace Den\Php2024;

class ListNode
{
    public function __construct(
        public ?int $value = null,
        public ?ListNode $next = null,
    ) {
    }

    public function setNext(ListNode $listNode): ListNode
    {
        $this->next = $listNode;
        return $listNode;
    }
}
