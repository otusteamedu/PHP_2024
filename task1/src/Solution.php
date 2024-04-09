<?php

declare(strict_types=1);

namespace App;

class Solution
{
    /**
     * @param ListNode $head
     * @return bool
     */
    public function hasCycle(ListNode $head): bool
    {
        if ($head === null || $head === '') {
            return false;
        }
        $slow = $head;
        $fast = $head->next;
        while ($slow !== $fast) {
            if ($fast == null || $fast->next == null) {
                return false;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }
        return true;
    }
}
