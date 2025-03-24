<?php

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(?ListNode $head): bool
    {
        if ($head === null || $head->next === null) {
            return false;
        }

        $slow = $head;
        $fast = $head;

        while ($fast !== null && $fast->next !== null) {
            $slow = $slow->next; // перемещение на 1
            $fast = $fast->next->next; // перемещение на 2

            if ($slow === $fast) {
                return true; // Цикл найден
            }
        }

        return false; // Цикла нет
    }
}

/**
 * 1. Временная сложность: O(n)
 * 2. Пространственная сложность: O(1)
 */
