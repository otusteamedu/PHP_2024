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
        $length = count($data);

        if (0 === $length) {
            return null;
        }

        $list = $current = new self($data[0]);

        for ($i = 1; $i < $length; $i++) {
            $current->setNext(new self($data[$i]));
            $current = $current->getNext();
        }

        return $list;
    }

    public static function createCycledFromArray(array $data, int $position): ?self
    {
        $length = count($data);

        if (0 === $length) {
            return null;
        }

        if ($position < 0 || $position >= $length) {
            return null;
        }

        $list = $current = $cycledNode = new self($data[0]);
        $lastNodeIndex = $length - 1;

        for ($i = 1; $i < $length; $i++) {
            $current->setNext(new self($data[$i]));
            $current = $current->getNext();

            if ($i === $position) {
                $cycledNode = $current;
            }

            if ($i === $lastNodeIndex) {
                $current->setNext($cycledNode);
            }
        }

        return $list;
    }
}
