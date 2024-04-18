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
        if ($head === null || $head->next === null) {
            return false;
        }

        $slow = $head;
        $fast = $head->next;

        while ($fast !== null && $fast->next !== null) {
            if ($slow === $fast) {
                return true;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return false;
    }
}
