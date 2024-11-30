<?php

declare(strict_types=1);

namespace LinkedListCycle;

class Solution
{
    public function hasCycle(?ListNode $head): bool
    {
        $slowPointer = $head;
        $fastPointer = $head;

        while ($slowPointer && $slowPointer->next) {
            $slowPointer = $slowPointer->next;
            $fastPointer = $fastPointer->next->next;

            if ($slowPointer === $fastPointer) {
                return true;
            }
        }
        return false;
    }
}

// Сложность O(n) т.к зависит от длины списка
