<?php

declare(strict_types=1);

namespace Irayu\Hw14\Domain\LinkedListCycle;

class RudeSolution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */

    public function hasCycle($head)
    {
        if ($head === null) {
            return false;
        }

        while ($head->next !== null) {
            if ($head->visited === true) {
                return true;
            }
            $head->visited = true;
            $head = $head->next;
        }

        return false;
    }
}
