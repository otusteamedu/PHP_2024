<?php

declare(strict_types=1);

namespace Irayu\Hw14\Domain\LinkedListCycle;

class StraightSolution
{
    protected $vals = [];
    /**
     * @param ListNode $head
     * @return Boolean
     */

    public function hasCycle($head)
    {
        if ($head === null || $head->next === null) {
            return false;
        }

        $headPointer = $head;
        $head = $head->next;
        $headPointer->next = null;

        while ($head !== null) {
            $visited = $headPointer;
            do {
                if ($visited === $head) {
                    return true;
                }
                if ($visited->next === null) {
                    break;
                }
                $visited = $visited->next;
            } while (true);

            $visited->next = $head;
            $head = $head->next;
            $visited->next->next = null;
            unset($visited);
        }

        return false;
    }
}
