<?php

declare(strict_types=1);

namespace Alogachev\Homework;

class CycledList
{
    /**
     * @param ListNode $head
     * @return bool
     */
    public function hasCycle($head): bool
    {
        $visited = [];

        while ($head!== null) {
            $nodeId = spl_object_hash($head);
            if (isset($visited[$nodeId])) {
                return true;
            }

            $visited[$nodeId] = true;
            $head = $head->next;
        }

        return false;
    }
}
