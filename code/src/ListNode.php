<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm;

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

    public static function createFromArray(array $data): ?self
    {
        if (0 === count($data)) {
            return null;
        }

        $list = $current = new self($data[0]);
        $length = count($data);

        for ($i = 1; $i < $length; $i++) {
            $current->setNext(new self($data[$i]));
            $current = $current->getNext();
        }

        return $list;
    }
}
