<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\LinkedList;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head): bool
    {
        if (!$head->next) {
            return false;
        }
        $head = $head->next;
        $head2 = $head->next;

        while (true) {
            if ($head === $head2) {
                return true;
            }
            if (!$head2 || !$head2->next || !$head2->next->next || !$head->next) {
                return false;
            }
            $head = $head->next;
            $head2 = $head2->next->next;
        }
    }
}
