<?php

namespace sd;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head)
    {
        if (empty($head) || empty($head->next)) {
            return false;
        }

        $next = $head->next;
        $nextSecond = $head->next->next;
        if ($next === $nextSecond) {
            return true;
        }

        while ($nextSecond && $nextSecond->next) {
            $next = $next->next;
            $nextSecond = $nextSecond->next->next;

            if ($next === $nextSecond) {
                return true;
            }
        }

        return false;
    }
}
