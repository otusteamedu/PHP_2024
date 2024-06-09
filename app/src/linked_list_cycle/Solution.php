<?php

namespace Dsergei\Hw5\linked_list_cycle;

use Dsergei\Hw14\linked_list_cycle\ListNode;

class Solution
{
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
