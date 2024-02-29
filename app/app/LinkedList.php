<?php

declare(strict_types=1);

namespace Rmulyukov\Hw8;

final class LinkedList
{
    public function __construct(
        private readonly int $value = 0,
        private ?LinkedList $next = null
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getNext(): ?LinkedList
    {
        return $this->next;
    }

    public function setNext(?LinkedList $list): LinkedList
    {
        $this->next = $list;
        return $this->next;
    }
}
