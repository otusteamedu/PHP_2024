<?php

declare(strict_types=1);

namespace App;

class Solution
{
    /**
     * @param ListNode $head
     * @return bool
     */
    function hasCycle(ListNode $head): bool
    {
        $fast = $head->next;
        while ($head != $fast) {
            if (is_int($fast->next)) {
                if ($fast->next >= 0) {
                    $fast->next = $head;
                    return true;
                } else {
                    return false;
                }
            }
            if ($fast->next == null) {
                return false;
            }
            $head = $head->next;
            $fast = $fast->next->next;
        }
        return true;
    }
}
