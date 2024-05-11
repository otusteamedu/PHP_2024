<?php

declare(strict_types=1);

namespace AlexanderGladkov\LinkedListCycle;

class Solution
{
    /**
     * @param ListNode|null $head
     * @return bool
     */
    public function haseCycle(?ListNode $head): bool
    {
        if ($head === null) {
            return false;
        }

        $slowNode = $head;
        $fastNode = $head->next;
        while ($slowNode !== $fastNode) {
            if ($fastNode === null || $fastNode->next === null) {
                return false;
            }

            $slowNode = $slowNode->next;
            $fastNode = $fastNode->next->next;
        }

        return true;
    }
}
