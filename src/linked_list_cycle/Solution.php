<?php

declare(strict_types=1);

namespace Afilipov\Hw14\linked_list_cycle;

class Solution
{
    /**
     * Алгоритмическая сложность - O(n)
     * @param ListNode|null $head
     * @return bool
     */
    public function hasCycle(?ListNode $head): bool
    {
        if ($head === null || $head->next === null) {
            return false;
        }

        $slow = $head;
        $fast = $head->next;

        while ($slow !== $fast) {
            if ($fast === null || $fast->next === null) {
                return false;
            }

            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return true;
    }
}
