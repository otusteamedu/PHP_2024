<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm2;

class ListNode
{
    public function __construct(
        private readonly int|float $value,
        private ?ListNode $next = null,
    ) {
    }

    public function setNext(?ListNode $next): void
    {
        $this->next = $next;
    }

    public function getValue(): float|int
    {
        return $this->value;
    }

    public function getNext(): ?ListNode
    {
        return $this->next;
    }
}
