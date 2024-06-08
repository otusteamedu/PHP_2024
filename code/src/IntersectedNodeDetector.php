<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm2;

class IntersectedNodeDetector
{
    private array $hash = [];

    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $currentA = $headA;
        $currentB = $headB;

        do {
            $this->addToHash($currentA);

            if ($this->hasIntersect()) {
                return $currentA;
            }

            $this->addToHash($currentB);

            if ($this->hasIntersect()) {
                return $currentB;
            }

            $currentA = $currentA?->getNext();
            $currentB = $currentB?->getNext();
        } while (null !== $currentA || null !== $currentB);

        return null;
    }

    private function addToHash(?ListNode $node): void
    {
        if (null === $node) {
            return;
        }

        $objectId = spl_object_id($node);

        if (isset($this->hash[$objectId])) {
            $this->hash[$objectId]++;
        } else {
            $this->hash[$objectId] = 1;
        }
    }

    private function hasIntersect(): bool
    {
        return in_array(2, $this->hash, true);
    }
}
