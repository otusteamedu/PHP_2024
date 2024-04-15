<?php

declare(strict_types=1);

// Сложность O(n)

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        if (is_null($head)) {
            return false;
        }

        do {
            if ($head->next === -1) { // Использую это как пометку пройденного узла
                return true;
            }

            $next = $head->next;
            $head->next = -1;
            $head = $next;
        } while (!is_null($head->next));

        return false;
    }
}

