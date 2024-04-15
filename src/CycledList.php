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
        $pos = -1;
        while (!is_null($head->next)) {
            $pos++;
            $head = $head->next;
            if ($pos === 2) {
                return true;
            }
        }

        return false;
    }
}
