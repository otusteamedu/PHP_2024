<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm2;

readonly class TwoListNodesDto
{
    public function __construct(public ListNode $headA, public ListNode $headB)
    {
    }
}
