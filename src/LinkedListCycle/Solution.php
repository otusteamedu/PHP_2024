<?php

namespace KRudenko\Otus\LinkedListCycle;

class Solution
{
    function hasCycle(?ListNode $head): bool
    {
        if (!$head || !$head->next) {
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
